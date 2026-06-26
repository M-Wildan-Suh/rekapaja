<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Category;
use App\Models\Highlight;
use App\Models\NoHandphone;
use App\Models\PivotProductTag;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\ProductTag;
use App\Models\Template;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProductController extends Controller
{
    private function ensureAdmin()
    {
        abort_unless(Auth::user() && in_array(Auth::user()->role, ['admin', 'superadmin']), 403);
    }

    private function ensureProductAccess(Product $product)
    {
        $user = Auth::user();

        if ($user && in_array($user->role, ['admin', 'superadmin'])) {
            return;
        }

        $hasAccess = Access::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->exists();

        abort_unless($hasAccess, 403);
    }

    private function storeProductImage($imageFile): string
    {
        $imageName = Str::uuid()->toString() . '.webp';
        $imagePath = public_path('storage/images/product/');

        if (!is_dir($imagePath)) {
            mkdir($imagePath, 0755, true);
        }

        $manager = new ImageManager(new Driver());
        $image = $manager->read($imageFile->getPathname());
        $image->toWebp(85)->save($imagePath . $imageName);

        return $imageName;
    }

    public function dashboard ()
    {
        $no_tlp = NoHandphone::query()->value('no_tlp');

        if (Auth::user()->role === 'admin') {
            $data = Product::all();
            $tag = ProductTag::all();
        } else {
            $productIds = Access::where('user_id', Auth::id())->pluck('product_id');
            $data = Product::whereIn('id', $productIds)->get();
            $tag = ProductTag::all();
        }
        return view('dashboard', compact('data', 'no_tlp'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect()->route('dashboard');
        // dd(Auth::user()->role);
        $no_tlp = NoHandphone::query()->value('no_tlp');

        if (Auth::user()->role === 'admin') {
            $data = Product::all();
            $tag = ProductTag::all();
        } else {
            $productIds = Access::where('user_id', Auth::id())->pluck('product_id');
            $data = Product::whereIn('id', $productIds)->get();
            $tag = ProductTag::all();
        }
        return view('admin.product.index', compact('data', 'no_tlp'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->ensureAdmin();

        $tag = ProductTag::all();
        $category = Category::all();
        $template = Template::all();
        $product = Product::all();
        $accessUsers = User::where('role', '!=', 'admin')->orderBy('name')->get();

        return view('admin.product.create', compact('tag', 'template', 'product', 'category', 'accessUsers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:products,name'],
            'subtitle' => ['required', 'string', 'max:255'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'template_id' => ['required', 'exists:templates,id'],
            'description' => ['required', 'string'],
            'address' => ['nullable', 'string', 'max:255'],
            'no_tlp' => ['nullable', 'string', 'max:20'],
            'link' => ['nullable', 'url', 'max:255'],
            'home_button' => ['required', 'in:on,off'],
            'thumbnail' => ['required', 'image'],
            'category' => ['nullable', 'array'],
            'category.*' => ['nullable', 'string', 'max:255'],
            'tag' => ['nullable', 'array'],
            'tag.*' => ['nullable', 'string', 'max:255'],
            'access' => ['nullable', 'array'],
            'access.*' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        $newdata= new Product();

        $newdata->name = $validated['name'];
        $newdata->slug = Str::slug($newdata->name);
        $newdata->subtitle = $validated['subtitle'];
        $newdata->price = $validated['price'] ?? null;
        $newdata->template_id = $validated['template_id'];
        $newdata->description = $validated['description'];
        $newdata->address = $validated['address'] ?? null;
        $newdata->no_tlp = $validated['no_tlp'] ?? null;
        $newdata->youtube = $validated['link'] ?? null;
        $newdata->home_button = $validated['home_button'];
        $newdata->status = 'active';

        if ($request->hasFile('thumbnail')) {
            $newdata->image = $this->storeProductImage($request->file('thumbnail'));
        }

        $newdata->save();

        if (!empty($validated['category'])) {
            $categoryIds = [];
            foreach ($validated['category'] as $categoryName) {
                $category = Category::firstOrCreate(['category' => $categoryName]);
                $categoryIds[] = $category->id;
            }
            $newdata->category()->attach($categoryIds);

        }

        Category::doesntHave('products')->forceDelete();

        if (!empty($validated['tag'])) {
            foreach ($validated['tag'] as $item) {
                $tag = ProductTag::where('tag', $item)->first();
                
                if ($tag) {
                    $newpivot = new PivotProductTag;
    
                    $newpivot->tag_id = $tag->id;
                    $newpivot->product_id = $newdata->id;
    
                    $newpivot->save();
                } else {
                    $newtag = new ProductTag;

                    $newtag->tag = ucfirst($item);

                    $newtag->save();

                    $newpivot = new PivotProductTag;
    
                    $newpivot->tag_id = $newtag->id;
                    $newpivot->product_id = $newdata->id;
    
                    $newpivot->save();
                }
                
            }
        }

        if (Auth::user()->role === 'admin') {
            $userIds = User::where('role', '!=', 'admin')
                ->whereIn('id', $validated['access'] ?? [])
                ->pluck('id');

            foreach ($userIds as $userId) {
                Access::create([
                    'user_id' => $userId,
                    'product_id' => $newdata->id,
                ]);
            }
        }
          
        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $this->ensureProductAccess($product);

        $product->productTags->transform(function ($data) {
            $data->tag = $data->productTag->tag;
            return $data;
        });
        
        // Mengambil semua ID dari productTags yang harus dikecualikan
        $tagexist = $product->productTags->pluck('productTag.id');
        $categoryexist = $product->category->pluck('id');
        
        // Memfilter tag berdasarkan ID yang tidak ada di tagexist
        $tag = ProductTag::whereNotIn('id', $tagexist)->get();
        $category = Category::whereNotIn('id', $categoryexist)->get();
        // dd($tag);

        $template = Template::all();
        $data = Product::whereNotIn('id', [$product->id])->get();
        $accessUsers = User::where('role', '!=', 'admin')->orderBy('name')->get();
        
        return view('admin.product.edit', compact('product', 'tag', 'template', 'category', 'data', 'accessUsers'));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    public function productorder($id, Request $request)
    {
        $validated = $request->validate([
            'order_title' => ['required', 'string', 'max:255'],
        ]);

        $data = Product::findOrFail($id);
        $this->ensureProductAccess($data);

        $data->order_title = $validated['order_title'];

        $data->save();

        return redirect()->back()->with('highlight', 'highlight');
    }
    
    
    public function producttitle($id, Request $request)
    {
        $validated = $request->validate([
            'product_title' => ['required', 'string', 'max:255'],
        ]);

        $data = Product::findOrFail($id);
        $this->ensureProductAccess($data);

        $data->product_title = $validated['product_title'];

        $data->save();

        return redirect()->back()->with('highlight', 'highlight');
    }

    public function downloadDomainFile(Product $product)
    {
        $this->ensureProductAccess($product);

        $appUrl = rtrim(config('app.url'), '/');
        $apiBaseUrl = $appUrl . '/api/business';
        $slug = $product->slug;
        $title = addslashes($product->name);

        $content = <<<PHP
<?php
\$apiBaseUrl = '{$apiBaseUrl}';
\$slug = '{$slug}';
\$apiUrl = rtrim(\$apiBaseUrl, '/') . '/' . rawurlencode(\$slug);

function loadBusinessData(\$url) {
    \$errors = [];

    \$context = stream_context_create([
        'http' => [
            'timeout' => 20,
            'header' => "User-Agent: RekapAjaDomainClient/1.0\r\n",
        ],
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
    ]);

    \$json = @file_get_contents(\$url, false, \$context);
    if (\$json !== false) {
        \$decoded = json_decode(\$json, true);
        if (is_array(\$decoded)) {
            return [\$decoded, null];
        }
        \$errors[] = 'Respons API bukan JSON yang valid.';
    } else {
        \$lastError = error_get_last();
        if (!empty(\$lastError['message'])) {
            \$errors[] = \$lastError['message'];
        }
    }

    if (function_exists('curl_init')) {
        \$ch = curl_init(\$url);
        curl_setopt_array(\$ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_USERAGENT => 'RekapAjaDomainClient/1.0',
        ]);
        \$response = curl_exec(\$ch);
        \$curlError = curl_error(\$ch);
        \$statusCode = (int) curl_getinfo(\$ch, CURLINFO_HTTP_CODE);
        curl_close(\$ch);

        if (\$response !== false && \$statusCode >= 200 && \$statusCode < 300) {
            \$decoded = json_decode(\$response, true);
            if (is_array(\$decoded)) {
                return [\$decoded, null];
            }
            \$errors[] = 'Curl menerima respons, tetapi JSON tidak valid.';
        } else {
            \$errors[] = \$curlError ?: 'Curl gagal dengan HTTP status ' . \$statusCode . '.';
        }
    } else {
        \$errors[] = 'Curl tidak tersedia di hosting ini.';
    }

    return [null, implode(' | ', array_filter(array_unique(\$errors)))];
}

function e(\$value) {
    return htmlspecialchars((string) \$value, ENT_QUOTES, 'UTF-8');
}

[\$data, \$loadError] = loadBusinessData(\$apiUrl);

if (!is_array(\$data)) {
    http_response_code(502);
    echo '<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Gagal Memuat Data</title></head><body style="font-family:Arial,sans-serif;padding:24px;line-height:1.6">';
    echo '<h1>Data usaha tidak dapat dimuat.</h1>';
    echo '<p>URL API yang dicoba: <code>' . e(\$apiUrl) . '</code></p>';
    if (\$loadError) {
        echo '<p><strong>Detail error:</strong> ' . e(\$loadError) . '</p>';
    }
    echo '<p>Jika ini di hosting shared, biasanya penyebabnya adalah request keluar ke domain utama diblokir, SSL/cURL tidak aktif, atau URL API utama belum bisa diakses publik.</p>';
    echo '</body></html>';
    exit;
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= e(\$data['name'] ?? '{$title}') ?></title>
  <style>
    body{font-family:Arial,sans-serif;margin:0;background:#f6f6f6;color:#111}
    .wrap{max-width:760px;margin:0 auto;padding:24px}
    .card{background:#fff;border-radius:18px;overflow:hidden;box-shadow:0 10px 30px rgba(0,0,0,.08)}
    .hero{width:100%;display:block;aspect-ratio:16/10;object-fit:cover;background:#eee}
    .content{padding:24px}
    h1{margin:0 0 8px;font-size:32px}
    p{line-height:1.6}
    .grid{display:grid;gap:12px;margin-top:20px}
    .item{padding:14px 16px;border:1px solid #e8e8e8;border-radius:14px}
    .price{font-weight:700;color:#ff7100}
    .badge{display:inline-block;margin-top:8px;padding:4px 10px;border-radius:999px;font-size:12px;background:#dcfce7;color:#166534}
    .badge.off{background:#fee2e2;color:#991b1b}
    .btn{display:inline-block;margin-top:20px;background:#16a34a;color:#fff;text-decoration:none;padding:12px 18px;border-radius:12px;font-weight:700}
  </style>
</head>
<body>
  <div class="wrap">
    <div class="card">
      <?php if (!empty(\$data['image'])): ?>
        <img class="hero" src="<?= e(\$data['image']) ?>" alt="<?= e(\$data['name'] ?? '') ?>">
      <?php endif; ?>
      <div class="content">
        <h1><?= e(\$data['name'] ?? '') ?></h1>
        <?php if (!empty(\$data['subtitle'])): ?><p><strong><?= e(\$data['subtitle']) ?></strong></p><?php endif; ?>
        <?php if (!empty(\$data['description'])): ?><p><?= nl2br(e(\$data['description'])) ?></p><?php endif; ?>

        <?php if (!empty(\$data['products'])): ?>
          <div class="grid">
            <?php foreach (\$data['products'] as \$item): ?>
              <div class="item">
                <strong><?= e(\$item['title'] ?? '') ?></strong><br>
                <?php if (!empty(\$item['price_text'])): ?><span class="price"><?= e(\$item['price_text']) ?></span><br><?php endif; ?>
                <?php if (!empty(\$item['description'])): ?><small><?= e(\$item['description']) ?></small><br><?php endif; ?>
                <span class="badge<?= empty(\$item['available']) ? ' off' : '' ?>">
                  <?= !empty(\$item['available']) ? 'Tersedia' : 'Kosong' ?>
                </span>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <?php if (!empty(\$data['whatsapp_url'])): ?>
          <a class="btn" href="<?= e(\$data['whatsapp_url']) ?>" target="_blank" rel="noopener">Order via WhatsApp</a>
        <?php elseif (!empty(\$data['detail_url'])): ?>
          <a class="btn" href="<?= e(\$data['detail_url']) ?>" target="_blank" rel="noopener">Lihat Detail</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>
</html>
PHP;

        return response()->streamDownload(function () use ($content) {
            echo $content;
        }, 'index.php', [
            'Content-Type' => 'application/octet-stream',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->ensureProductAccess($product);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('products', 'name')->ignore($product->id)],
            'subtitle' => ['required', 'string', 'max:255'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'template_id' => ['required', 'exists:templates,id'],
            'description' => ['required', 'string'],
            'address' => ['nullable', 'string', 'max:255'],
            'no_tlp' => ['nullable', 'string', 'max:20'],
            'link' => ['nullable', 'url', 'max:255'],
            'home_button' => ['nullable', 'in:on,off'],
            'status' => ['nullable', 'in:active,unactive'],
            'thumbnail' => ['nullable', 'image'],
            'category' => ['nullable', 'array'],
            'category.*' => ['nullable', 'string', 'max:255'],
            'tag' => ['nullable', 'array'],
            'tag.*' => ['nullable', 'string', 'max:255'],
            'access' => ['nullable', 'array'],
            'access.*' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        $product->name = $validated['name'];
        $product->slug = Str::slug($product->name);
        $product->subtitle = $validated['subtitle'];
        $product->price = $validated['price'] ?? null;
        $product->template_id = $validated['template_id'];
        $product->description = $validated['description'];
        $product->address = $validated['address'] ?? null;
        $product->no_tlp = $validated['no_tlp'] ?? null;
        $product->youtube = $validated['link'] ?? null;

        if (array_key_exists('home_button', $validated)) {
            $product->home_button = $validated['home_button'];
        }

        if (!empty($validated['status'])) {
            $product->status = $validated['status'];
        }

        if ($request->hasFile('thumbnail')) {
            $newImageName = $this->storeProductImage($request->file('thumbnail'));

            if ($product->image) {
                $path = public_path('storage/images/product/' . $product->image);

                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $product->image = $newImageName;
        }

        $product->save();

        if (!empty($validated['category'])) {
            $categoryIds = [];
            foreach ($validated['category'] as $categoryName) {
                $category = Category::firstOrCreate(['category' => $categoryName]);
                $categoryIds[] = $category->id;
            }

            $product->category()->sync($categoryIds);
        }

        Category::doesntHave('products')->forceDelete();

        PivotProductTag::where('product_id', $product->id)->delete();
        
        if (!empty($validated['tag'])) {
            // Hapus data pivot yang memiliki product_id sesuai
        
            foreach ($validated['tag'] as $item) {
                $tag = ProductTag::where('tag', $item)->first();
        
                if ($tag) {
                    $newpivot = new PivotProductTag;
    
                    $newpivot->tag_id = $tag->id;
                    $newpivot->product_id = $product->id;
    
                    $newpivot->save();
                } else {
                    $newtag = new ProductTag;
        
                    $newtag->tag = ucfirst($item);
        
                    $newtag->save();
        
                    $newpivot = new PivotProductTag;
        
                    $newpivot->tag_id = $newtag->id;
                    $newpivot->product_id = $product->id;
        
                    $newpivot->save();
                }
            }
        }

        if (Auth::user()->role === 'admin') {
            $userIds = User::where('role', '!=', 'admin')
                ->whereIn('id', $validated['access'] ?? [])
                ->pluck('id')
                ->all();

            Access::where('product_id', $product->id)->delete();

            foreach ($userIds as $userId) {
                Access::create([
                    'user_id' => $userId,
                    'product_id' => $product->id,
                ]);
            }
        }
        

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->ensureAdmin();

        // Delete the main product image if it exists
        $path = public_path('storage/images/product/' . $product->image);
        if (file_exists($path)) {
            unlink($path);
        }

        // Fetch associated product gallery images
        $productGalleries = ProductGallery::where('product_id', $product->id)->get();

        // Loop through each gallery image and delete it
        foreach ($productGalleries as $gallery) {
            $galleryPath = public_path('storage/images/product/gallery/' . $gallery->image); // Adjust the path as needed
            if (file_exists($galleryPath)) {
                unlink($galleryPath);
            }
            // Delete the gallery record from the database
            $gallery->delete();
        }

        $highlight = Highlight::where('product_id', $product->id)->get();

        foreach ($highlight as $item) {
            $galleryPath = public_path('storage/images/product/highlight/' . $item->image); // Adjust the path as needed
            if (file_exists($galleryPath)) {
                unlink($galleryPath);
            }
            $item->delete();
        }

        // Finally, delete the product
        $product->delete();

        return redirect()->back()->with('success', 'product and its gallery images deleted successfully.');
    }
}
