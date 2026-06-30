<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Category;
use App\Models\Highlight;
use App\Models\Invoice;
use App\Models\NoHandphone;
use App\Models\PivotProductTag;
use App\Models\PremiumPackage;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\ProductTag;
use App\Models\Template;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Composer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class PageController extends Controller
{
    private function normalizeDomainUrl(?string $domain): ?string
    {
        $domain = trim((string) $domain);

        if ($domain === '') {
            return null;
        }

        if (!preg_match('~^https?://~i', $domain)) {
            $domain = 'https://' . $domain;
        }

        $parts = parse_url($domain);

        if (!$parts || empty($parts['host'])) {
            return null;
        }

        $scheme = strtolower($parts['scheme'] ?? 'https');
        if (!in_array($scheme, ['http', 'https'], true)) {
            return null;
        }

        $normalized = $scheme . '://' . strtolower($parts['host']);

        if (!empty($parts['port'])) {
            $normalized .= ':' . $parts['port'];
        }

        return rtrim($normalized, '/');
    }

    public function home(Request $request) {
        // dd($request->filter);
        $no_tlp = $this->getWhatsappNumber();
        $data = Product::where('status', 'active')->inRandomOrder()->get();
        return view('welcome', compact('data', 'no_tlp'));
    }

    public function product(Request $request) {
        // dd($request->filter);
        Paginator::currentPageResolver(function () use ($request) {
            return $request->route('page', 1); // default ke halaman 1
        });
    
        $no_tlp = $this->getWhatsappNumber();
    
        $seed = Carbon::now()->format('Ymd');
        $search = $request->search;
        $page = $request->route('page', 1);
        $perPage = 10;
    
        // Buat cache key unik per hari dan per keyword
        $cacheKey = $search ? "products_random_ids_{$seed}_search_" . md5($search) : "products_random_ids_{$seed}";
    
        $productIds = Cache::remember($cacheKey, now()->endOfDay(), function () use ($search, $seed) {
            $query = Product::where('status', 'active');
    
            if ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhereHas('productTags', function ($q) use ($search) {
                            $q->whereHas('productTag', function ($q2) use ($search) {
                                $q2->where('tag', 'like', '%' . $search . '%');
                            });
                        })
                        ->orWhereHas('category', function ($q) use ($search) {
                            $q->where('category', 'like', '%' . $search . '%');
                        });
                });
            }
    
            return $query->select('id')
                ->orderByRaw("SHA1(CONCAT(id, '$seed'))")
                ->pluck('id')
                ->toArray();
        });
    
        $slicedIds = array_slice($productIds, ($page - 1) * $perPage, $perPage);
    
        $data = Product::whereIn('id', $slicedIds)->get()->sortBy(function ($item) use ($slicedIds) {
            return array_search($item->id, $slicedIds);
        });
    
        // Buat paginator manual
        $data = new LengthAwarePaginator(
            $data,
            count($productIds),
            $perPage,
            $page,
            [
                'path' => url('/bisnis/page'),
                'query' => $request->only('search'),
            ]
        );
    
        $category = Category::all();
        $template = Template::inRandomOrder()->get();
    
        return view('product', compact('data', 'no_tlp', 'template', 'category'));
    }

    public function categorybusiness($category, Request $request) {
        Paginator::currentPageResolver(function () use ($request) {
            return $request->route('page', 1); // default ke halaman 1
        });

        $no_tlp = $this->getWhatsappNumber();

        $filter = $category;

        $category = Category::where('category', $category)->first();

        $data = Product::where('status', 'active')->whereHas('category', function ($query) use ($category) {
            $query->where('category_id', $category->id);
        })->paginate(10);

        $category->category = Str::lower($category->category);

        $data->withPath("/bisnis/kategori/{$category->category}/page");

        $category = Category::all();
        $template = Template::inRandomOrder()->get();
        return view('product', compact('data', 'no_tlp', 'template', 'category', 'filter'));
    }

    public function template(Request $request) {
        $no_tlp = $this->getWhatsappNumber();
        if ($request->search) {
            $data = Template::where('name', 'like', '%' . $request->search . '%')->get();
        } else {
            $data = Template::all();
        }
        $data = $data->map(function ($item) {
            $item->slug = Str::slug($item->name, '-');
            return $item;
        });
        return view('template', compact('data', 'no_tlp'));
    }

    public function detail(Request $request, $slug) {
        $data = Product::where('slug', $slug)->first();
        
        if (!$data) {
            return view('not-found');
        }

        $customDomain = $this->normalizeDomainUrl($data->domain);
        if ($customDomain && !$request->boolean('domain_preview')) {
            $currentOrigin = rtrim($request->getSchemeAndHttpHost(), '/');
            if (strcasecmp($currentOrigin, $customDomain) !== 0) {
                $queryString = $request->getQueryString();
                return redirect()->away($customDomain . ($queryString ? '?' . $queryString : ''), 301);
            }
        }

        $template = Template::find($data->template_id);

        $accesses = Access::with('user')->where('product_id', $data->id)->get();

        // Role Validation
        if ($accesses->isNotEmpty()) {
            $premiumAccess = $accesses->first(function ($access) {
                return $access->user && $access->user->canAccessPremiumFeatures();
            });

            // No Telephone
            if ($premiumAccess) {
                if ($data->no_tlp) {
                    $no_tlp = $data->no_tlp;
                } else {
                    $no_tlp = $this->getRawWhatsappNumber();
                }
                $role = $premiumAccess->user->role === 'admin' ? 'admin' : 'premium';
            } else {
                $role = 'user';
                $no_tlp = $this->getRawWhatsappNumber();
            }
        } else {
            $no_tlp = $this->getRawWhatsappNumber();

            $role = 'admin';
        }

        $data->image = asset('storage/images/product/'. $data->image);

        $data->productGallery = $data->productGallery->map(function ($item) {
            $item->image = asset('storage/images/product/gallery/'. $item->image);
            return $item;
        });
        
        $data->productHighlight = $data->productHighlight->map(function ($item) {
            $item->image = asset('storage/images/product/highlight/'. $item->image);
            return $item;
        });

        if (!$data) {
            return redirect()->route('home');
        }

        $no_tlp = $this->formatWhatsappNumber($no_tlp);

        // Url Youtube
        $url = $data->youtube;
        $parsedUrl = parse_url($url);
        $videoId = null;

        if (isset($parsedUrl['host'])) {
            if ($parsedUrl['host'] === 'youtu.be') {
                // Jika URL menggunakan youtu.be, ambil ID dari path
                $videoId = ltrim($parsedUrl['path'], '/');
            } elseif (strpos($parsedUrl['host'], 'youtube.com') !== false) {
                // Jika URL menggunakan youtube.com, periksa path dan query
                if (strpos($parsedUrl['path'], '/shorts/') === 0) {
                    // Jika URL adalah Shorts, ambil ID dari path
                    $videoId = ltrim(str_replace('/shorts/', '', $parsedUrl['path']), '/');
                } elseif (isset($parsedUrl['query'])) {
                    // Jika URL menggunakan query, ambil ID dari parameter 'v'
                    parse_str($parsedUrl['query'], $query);
                    $videoId = $query['v'] ?? null;
                }
            }
        }

        // Buat embed URL jika ID ditemukan
        $data->embed = $videoId ? "https://www.youtube.com/embed/" . $videoId : $data->youtube;

        return view('detail', compact('data', 'no_tlp', 'role', 'template'));

    }

    public function businessApi($slug)
    {
        $product = Product::with(['productHighlight', 'productGallery', 'productTags.productTag', 'category'])
            ->where('slug', $slug)
            ->first();

        if (!$product) {
            return response()->json([
                'message' => 'Usaha tidak ditemukan.',
            ], 404);
        }

        $rawWhatsapp = $product->no_tlp ?: $this->getRawWhatsappNumber();
        $formattedWhatsapp = $this->formatWhatsappNumber($rawWhatsapp);

        return response()->json([
            'name' => $product->name,
            'slug' => $product->slug,
            'subtitle' => $product->subtitle,
            'description' => $product->description,
            'image' => $product->image ? asset('storage/images/product/' . $product->image) : null,
            'qris_image' => $product->qris ? asset('storage/images/product/qris/' . $product->qris) : null,
            'detail_url' => $this->normalizeDomainUrl($product->domain) ?: route('detail', ['slug' => $product->slug]),
            'whatsapp_url' => $formattedWhatsapp ? 'https://wa.me/' . ltrim($formattedWhatsapp, '+') : null,
            'order_title' => $product->order_title,
            'categories' => $product->category->pluck('category')->values(),
            'tags' => $product->productTags->map(function ($item) {
                return optional($item->productTag)->tag;
            })->filter()->values(),
            'gallery' => $product->productGallery->map(function ($item) {
                return [
                    'image' => asset('storage/images/product/gallery/' . $item->image),
                ];
            })->values(),
            'products' => $product->productHighlight->map(function ($item) {
                return [
                    'title' => $item->title,
                    'price' => $item->price,
                    'price_text' => $item->price ? 'Rp' . number_format($item->price, 0, ',', '.') : null,
                    'description' => $item->description,
                    'image' => $item->image ? asset('storage/images/product/highlight/' . $item->image) : null,
                    'available' => (bool) $item->available,
                ];
            })->values(),
        ]);
    }

    public function businessOrderApi(Request $request, $slug)
    {
        $product = Product::with(['access.user'])->where('slug', $slug)->first();

        if (!$product) {
            return response()->json([
                'message' => 'Usaha tidak ditemukan.',
            ], 404);
        }

        $customerName = trim((string) $request->input('customer_name', ''));
        $customerAddress = trim((string) $request->input('customer_address', ''));

        $orders = $request->input('order', []);

        if (!is_array($orders) || empty($orders)) {
            return response()->json([
                'message' => 'Produk yang dipilih tidak valid.',
            ], 422);
        }

        if ($customerName === '' || $customerAddress === '') {
            return response()->json([
                'message' => 'Nama pemesan dan alamat wajib diisi.',
            ], 422);
        }

        $invoice = new Invoice;
        $invoice->business_id = $product->id;
        $invoice->invoice_code = strtoupper(Str::random(10));
        $invoice->invoice_text = '';

        $message = "Halo, saya ingin memesan produk/layanan Anda.\n";
        $tanggal = Carbon::now('Asia/Jakarta')->locale('id')->format('d-m-Y');
        $total = 0;
        $invoiceText = '';

        $invoiceText .= '<p style="font-size: 0.875rem; color: #525252; font-weight: 600;">Tanggal</p>';
        $invoiceText .= "<p>" . $tanggal . "</p>";
        $invoiceText .= '<p style="font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;">Nama Pemesan</p>';
        $invoiceText .= '<p>' . e($customerName) . '</p>';
        $invoiceText .= '<p style="font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;">Alamat</p>';
        $invoiceText .= '<p>' . nl2br(e($customerAddress)) . '</p>';
        $invoiceText .= '<p style="margin-top:8px;"><b>Detail Rekapan</b></p>';

        $message .= "Nama: {$customerName}\n";
        $message .= "Alamat: {$customerAddress}\n";

        foreach ($orders as $item) {
            if (!isset($item['id'])) {
                continue;
            }

            $highlight = Highlight::where('product_id', $product->id)
                ->where('id', $item['id'])
                ->first();

            if (!$highlight) {
                continue;
            }

            $quantity = max(1, (int) ($item['quantity'] ?? 1));
            $price = (int) ($highlight->price ?? 0);
            $subtotal = $price * $quantity;
            $total += $subtotal;

            $message .= "\n- " . $highlight->title . ", Jumlah: " . $quantity;

            $invoiceText .= '<div style="font-size: 0.875rem;display: flex; justify-content: space-between;"><b>- '
                . $highlight->title . '</b><p>'
                . $quantity . ' x ' . number_format($price, 0, ',', '.')
                . ' = ' . number_format($subtotal, 0, ',', '.') . '</p></div>';
        }

        if ($total === 0) {
            return response()->json([
                'message' => 'Tidak ada produk valid yang bisa diproses.',
            ], 422);
        }

        $invoiceText .= '<p style="font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;">Total</p>';
        $invoiceText .= "<b>Rp" . number_format($total, 0, ',', '.') . "</b>";
        $invoice->invoice_text = $invoiceText;
        $invoice->save();

        $invoiceUrl = url("/rekap/{$invoice->invoice_code}");
        $message .= "\n\nDetail Rekapan: {$invoiceUrl}";
        $message .= "\nUntuk produk/layanan diatas apakah masih tersedia?";

        $no_tlp = $this->resolveProductWhatsappNumber($product);
        $whatsappUrl = "https://wa.me/{$no_tlp}?text=" . urlencode($message);

        return response()->json([
            'redirect_url' => $whatsappUrl,
            'invoice_url' => $invoiceUrl,
        ]);
    }

    public function createproduct() {
        $tag = ProductTag::all();
        $product = Product::all();
        return view('create-product', compact('tag', 'product'));
    }

    public function storeproduct(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:'.Product::class,
            'subtitle' => 'required|string|max:255',
            'desc' => 'required|string',
            'no_tlp' => 'required|string|max:20',
            'thumbnail' => 'required|image',
            'domain' => ['nullable', 'string', 'max:255', function ($attribute, $value, $fail) {
                if ($value && !$this->normalizeDomainUrl($value)) {
                    $fail('Domain tidak valid.');
                }
            }],
            'image_gallery' => 'nullable|array|max:9',
            'image_gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',

            'inputs' => 'array|max:3',
            'inputs.*.image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'inputs.*.title' => 'required|string|max:27',
            'inputs.*.price' => 'nullable|numeric|min:0',
            'inputs.*.description' => 'required|string|max:64',
        ], [
            'inputs.max' => 'Maksimal hanya boleh 3 produk/layanan.',
            'inputs.*.image.required' => 'Gambar produk/layanan wajib diunggah.',
            'inputs.*.image.image' => 'File harus berupa gambar.',
            'inputs.*.image.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau svg.',
            'inputs.*.title.required' => 'Nama produk/layanan wajib diisi.',
            'inputs.*.title.max' => 'Nama produk/layanan maksimal 27 karakter.',
            'inputs.*.description.required' => 'Deskripsi produk/layanan wajib diisi.',
            'inputs.*.description.max' => 'Deskripsi maksimal 64 karakter.',
            'image_gallery.max' => 'Maksimal hanya boleh 9 gambar galeri.',
        ]);
    
        // Jika validasi gagal, kirim alert dan kembali
        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
    
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $newdata= new Product();

        $newdata->name = $request->name;
        $newdata->slug = Str::slug($newdata->name);
        $newdata->subtitle = $request->subtitle;
        $newdata->template_id = 1;
        $newdata->description = $request->desc;
        $newdata->no_tlp = $request->no_tlp;
        $newdata->domain = $this->normalizeDomainUrl($request->domain);

        if ($request->hasFile('thumbnail')) {
            $imageFile = $request->file('thumbnail');
            $imageName = time() . '.' . $imageFile->getClientOriginalExtension();
            $imagePath = public_path('storage/images/product/');

            $manager = new ImageManager(new Driver());
            $image = $manager->read($imageFile->getPathname());
            $imageFullPath = $imagePath . $imageName . '.webp';
            $image->save($imageFullPath);

            $newdata->image = $imageName . '.webp';
        }

        $newdata->save();

        if ($request->tag) {
            foreach ($request->tag as $item) {
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

        if ($request->inputs) {
            foreach ($request->inputs as $index => $item) {
                $newhighlight = new Highlight;

                $newhighlight->product_id = $newdata->id;
                $newhighlight->title = $item['title'];
                $newhighlight->price = $item['price'];
                $newhighlight->description = $item['description'];

                if ($request->hasFile('inputs.'.$index.'.image')) {
                    $image = $request->file('inputs.'.$index.'.image');
                    // Get the original filename without the extension
                    $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    
                    // Add the current date to the filename
                    $currentDate = now()->format('YmdHis');
                    
                    // Create a new image name
                    $imageName = $originalName . '_' . $currentDate;
                    
                    // Define the image storage path
                    $imagePath = public_path('storage/images/product/highlight/');
                    
                    $manager = new ImageManager(new Driver());
                    $imageOptimized = $manager->read($image->getPathname());
                    $imageFullPath = $imagePath . $imageName . '.webp';
                    $imageOptimized->save($imageFullPath);

                    $newhighlight->image = $imageName . '.webp';
                }
                $newhighlight->save();
            }
        }

        if ($request->file('image_gallery')) {
            foreach ($request->file('image_gallery') as $item) {
                $newgallery = new ProductGallery;
                $newgallery->product_id = $newdata->id;
                if ($item) {
                    $imageFile = $item;
                    $imageName = time() . '.' . $imageFile->getClientOriginalExtension();
                    $imagePath = public_path('storage/images/product/gallery/');
        
                    $manager = new ImageManager(new Driver());
                    $image = $manager->read($imageFile->getPathname());
                    $imageFullPath = $imagePath . $imageName . '.webp';
                    $image->save($imageFullPath);
        
                    $newgallery->image = $imageName . '.webp';
                }
                $newgallery->save();
            }
        }

        $no_tlp = $this->getWhatsappNumber();

        $text = urlencode("Halo, saya sudah mendaftarkan usaha Saya dengan nama usaha ".$newdata->name.". Saya tertarik dengan fitur-fitur yang ada dan ingin mengetahui lebih lanjut. Apakah bisa mendapatkan informasi lebih lengkap?");

        return redirect()->away('https://wa.me/'.$no_tlp.'?text=' . $text);
    }

    public function join() {
        $no_tlp = $this->getWhatsappNumber();

        $text = urlencode("Halo, Saya tertarik dengan fitur-fitur yang ada di byoo.link dan ingin mengetahui lebih lanjut.\n Apakah saya bisa mendapatkan informasi lebih lengkap?");

        return redirect()->away('https://wa.me/'.$no_tlp.'?text=' . $text);
    }

    public function order(Request $request, $no_tlp) {
        $customerName = trim((string) $request->input('customer_name', ''));
        $customerAddress = trim((string) $request->input('customer_address', ''));

        $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_address' => ['required', 'string', 'max:1000'],
            'order' => ['required', 'array'],
        ]);

        $invoice = new Invoice;

        $invoice->business_id = $request->product_id;
        $invoice->invoice_code = strtoupper(Str::random(10));
        $invoice->invoice_text = '';
        // $data = Highlight::whereIn('id', $request->order)->get();

        // $no_tlp = NoHandphone::first()->no_tlp;
        // $no_tlp = preg_replace('/^0/', '+62', $no_tlp);

        $message = "Halo, saya ingin memesan produk/layanan Anda.\n";
        $tanggal = Carbon::now('Asia/Jakarta')->locale('id')->format('d-m-Y');
        $total = 0;
        $invoiceText = '';

        $invoiceText .= '<p style="font-size: 0.875rem; color: #525252; font-weight: 600;">Tanggal</p>';
        $invoiceText .= "<p>" . $tanggal . "</p>";
        $invoiceText .= '<p style="font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;">Nama Pemesan</p>';
        $invoiceText .= '<p>' . e($customerName) . '</p>';
        $invoiceText .= '<p style="font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;">Alamat</p>';
        $invoiceText .= '<p>' . nl2br(e($customerAddress)) . '</p>';

        $invoiceText .= '<p style="margin-top:8px;"><b>Detail Rekapan</b></p>';
        $message .= "Nama: {$customerName}\n";
        $message .= "Alamat: {$customerAddress}\n";
        foreach ($request->order as $item) {
            // dd($item['id']);
            if (isset($item['id'])) {
                $data = Highlight::find($item['id']);
                if ($data) {
                    $subtotal = $data->price * $item['quantity'];
                    $total += $subtotal;
                    
                    $message .= "\n- " . $data->title . ", Jumlah: " . $item['quantity'];
                    
                    $invoiceText .= '<div style="font-size: 0.875rem;display: flex; justify-content: space-between;"><b>- '.$data->title.'</b><p>'. $item['quantity'] .' x '.number_format($data->price, 0, ',', '.').' = '. number_format($subtotal, 0, ',', '.') .'</p></div>';
                }
            }
        }
        $invoiceText .= '<p style="font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;">Total</p>';
        $invoiceText .= "<b>Rp" . number_format($total, 0, ',', '.') . "</b>";
        $invoice->invoice_text = $invoiceText;
        $invoice->save();

        $invoiceUrl = url("/rekap/{$invoice->invoice_code}");
        $message .= "\n\nDetail Rekapan: {$invoiceUrl}";
        $message .= "\nUntuk produk/layanan diatas apakah masih tersedia?";
        $whatsappUrl = "https://wa.me/{$no_tlp}?text=" . urlencode($message);

        return redirect()->away($whatsappUrl);
    }

    public function premiumPackage() {
        $no_tlp = $this->getWhatsappNumber();
        $data = PremiumPackage::all();
        return view('package', compact('data', 'no_tlp'));
    }

    public function buyPackage($id) {
        $no_tlp = $this->getWhatsappNumber();

        $data = PremiumPackage::find($id);

        $text = urlencode("Halo, Saya tertarik dengan paket ".$data->name." di rekapaja.webzz.id dan ingin membeli paket tersebut.\n Apakah saya bisa mendapatkan informasi lebih lengkap?");

        return redirect()->away('https://wa.me/'.$no_tlp.'?text=' . $text);
    }

    public function test() {
        $data = Product::where('status', 'active')->inRandomOrder()->get();
        return view('test', compact('data'));
    }

    private function getRawWhatsappNumber(): ?string
    {
        return NoHandphone::query()->value('no_tlp');
    }

    private function resolveProductWhatsappNumber(Product $product): string
    {
        $accesses = Access::with('user')->where('product_id', $product->id)->get();

        if ($accesses->isNotEmpty()) {
            $premiumAccess = $accesses->first(function ($access) {
                return $access->user && $access->user->canAccessPremiumFeatures();
            });

            if ($premiumAccess) {
                $no_tlp = $product->no_tlp ?: $this->getRawWhatsappNumber();
                return $this->formatWhatsappNumber($no_tlp);
            }
        } else {
            $no_tlp = $product->no_tlp ?: $this->getRawWhatsappNumber();
            return $this->formatWhatsappNumber($no_tlp);
        }

        return $this->formatWhatsappNumber($this->getRawWhatsappNumber());
    }

    private function getWhatsappNumber(): string
    {
        return $this->formatWhatsappNumber($this->getRawWhatsappNumber());
    }

    private function formatWhatsappNumber(?string $no_tlp): string
    {
        if (!$no_tlp) {
            return '';
        }

        return preg_replace('/^0/', '+62', $no_tlp);
    }
}
