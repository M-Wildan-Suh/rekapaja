<?php

namespace App\Services;

use App\Models\Access;
use App\Models\Product;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class VoucherService
{
    // Explicitly copy presentation fields, never deployment or account state.
    private const PRESENTATION_FIELDS = [
        'image', 'template', 'template_id', 'youtube', 'subtitle', 'price',
        'description', 'product_title', 'order_title', 'price_prefix',
        'no_tlp', 'address',
    ];

    public function redeem(string $code, User $user, bool $applyPremium = false): Product
    {
        $files = [];

        try {
            return DB::transaction(function () use ($code, $user, $applyPremium, &$files) {
                // Serialize redemptions for both the account and the voucher.
                $owner = User::whereKey($user->id)->lockForUpdate()->firstOrFail();
                if (Access::where('user_id', $owner->id)->exists()) {
                    throw ValidationException::withMessages(['voucher' => 'Akun ini sudah memiliki usaha.']);
                }

                $voucher = Voucher::where('code', Str::upper(trim($code)))->lockForUpdate()->first();
                if (!$voucher || $voucher->used_at || !$voucher->product_id) {
                    throw ValidationException::withMessages(['voucher' => 'Voucher tidak valid, sudah digunakan, atau usaha asal sudah dihapus.']);
                }

                $source = Product::whereKey($voucher->product_id)->lockForUpdate()->first();
                if (!$source) {
                    throw ValidationException::withMessages(['voucher' => 'Usaha asal voucher tidak tersedia.']);
                }

                $product = new Product;
                $product->forceFill($source->only(self::PRESENTATION_FIELDS));
                do {
                    $suffix = Str::upper(Str::random(4));
                    $product->name = Str::limit($source->name, 93, '').' - '.$suffix;
                    $product->slug = Str::slug($product->name);
                } while (Product::where('name', $product->name)->orWhere('slug', $product->slug)->exists());
                $product->image = $this->copyImage($source->image, 'storage/images/product', $files);
                $product->status = 'active';
                $product->home_button = 'on';
                $product->customer_data = 'unactive';
                $product->order_via_whatsapp = 'instan_rekap';
                $product->qris_status = 'unactive';
                $product->save();

                foreach ($source->productGallery as $gallery) {
                    $copy = new \App\Models\ProductGallery;
                    $copy->image = $this->copyImage($gallery->image, 'storage/images/product/gallery', $files);
                    $product->productGallery()->save($copy);
                }
                foreach ($source->productHighlight as $highlight) {
                    $copy = new \App\Models\Highlight;
                    $copy->forceFill($highlight->only(['title', 'price', 'description', 'available', 'rating']));
                    $copy->image = $this->copyImage($highlight->image, 'storage/images/product/highlight', $files);
                    $product->productHighlight()->save($copy);
                }
                $product->category()->attach($source->category->modelKeys());
                foreach ($source->productTags as $tag) {
                    $copy = new \App\Models\PivotProductTag;
                    $copy->tag_id = $tag->tag_id;
                    $product->productTags()->save($copy);
                }
                Access::create(['user_id' => $owner->id, 'product_id' => $product->id]);

                if ($applyPremium) {
                    $owner->role = $voucher->role;
                    $owner->premium_type = $voucher->role === 'premium' ? $voucher->premium_type : null;
                    $owner->expired = $voucher->role === 'premium' && $voucher->premium_type !== 'lifetime'
                        ? $voucher->expired : null;
                    $owner->save();
                }

                $voucher->used_by = $owner->id;
                $voucher->used_at = now();
                $voucher->save();

                return $product;
            });
        } catch (\Throwable $exception) {
            foreach ($files as $path) {
                if (is_file($path)) {
                    unlink($path);
                }
            }
            throw $exception;
        }
    }

    private function copyImage(?string $filename, string $directory, array &$files): ?string
    {
        if (!$filename) {
            return $filename;
        }
        $path = public_path($directory.'/'.basename($filename));
        if (!is_file($path)) {
            throw ValidationException::withMessages(['voucher' => 'Gambar usaha asal tidak tersedia. Hubungi admin untuk memperbaiki usaha asal.']);
        }
        $name = Str::uuid().'.'.pathinfo($filename, PATHINFO_EXTENSION);
        $target = public_path($directory.'/'.$name);
        if (!copy($path, $target)) {
            throw new \RuntimeException('Gagal menyalin gambar usaha.');
        }
        $files[] = $target;

        return $name;
    }
}
