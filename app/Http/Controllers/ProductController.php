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
use App\Services\CpanelDomainPublisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use RuntimeException;

class ProductController extends Controller
{
    public function __construct(
        private readonly CpanelDomainPublisher $cpanelDomainPublisher
    ) {
    }

    private function normalizeWholeNumberPrice(mixed $price): ?int
    {
        if ($price === null || $price === '') {
            return null;
        }

        if (is_string($price)) {
            $price = str_replace('.', '', $price);
        }

        return (int) $price;
    }

    private function syncIncompleteHighlightAvailability(Product $product): void
    {
        foreach ($product->productHighlight as $highlight) {
            $isValid = filled(trim((string) $highlight->title)) && filled($highlight->image);

            if (!$isValid && $highlight->available) {
                $highlight->available = false;
                $highlight->save();
            }
        }
    }

    private function canManageQris(): bool
    {
        return Auth::user()?->canAccessPremiumFeatures() ?? false;
    }

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

    private function storeImageAsWebp($imageFile, string $directory): string
    {
        $imageName = Str::uuid()->toString() . '.webp';
        $imagePath = public_path($directory);

        if (!is_dir($imagePath)) {
            mkdir($imagePath, 0755, true);
        }

        $manager = new ImageManager(new Driver());
        $image = $manager->read($imageFile->getPathname());
        $image->toWebp(85)->save($imagePath . DIRECTORY_SEPARATOR . $imageName);

        return $imageName;
    }

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
        return $this->storeImageAsWebp($imageFile, 'storage/images/product');
    }

    private function storeQrisImage($imageFile): string
    {
        return $this->storeImageAsWebp($imageFile, 'storage/images/product/qris');
    }

    private function deleteImageIfExists(?string $filename, string $directory): void
    {
        if (!$filename) {
            return;
        }

        $path = public_path(trim($directory, '/\\') . DIRECTORY_SEPARATOR . $filename);

        if (is_file($path)) {
            unlink($path);
        }
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

        $validated = $request->validate(array_merge([
            'name' => ['required', 'string', 'max:255', 'unique:products,name'],
            'subtitle' => ['required', 'string', 'max:255'],
            'price' => ['nullable', 'regex:/^\d+$/'],
            'template_id' => ['required', 'exists:templates,id'],
            'description' => ['required', 'string'],
            'address' => ['nullable', 'string', 'max:255'],
            'no_tlp' => ['nullable', 'string', 'max:20'],
            'domain' => ['nullable', 'string', 'max:255', function ($attribute, $value, $fail) {
                if ($value && !$this->normalizeDomainUrl($value)) {
                    $fail('Domain tidak valid.');
                }
            }],
            'price_prefix' => ['nullable', 'string', 'max:255'],
            'link' => ['nullable', 'url', 'max:255'],
            'home_button' => ['required', 'in:on,off'],
            'thumbnail' => ['required', 'image'],
            'category' => ['nullable', 'array'],
            'category.*' => ['nullable', 'string', 'max:255'],
            'tag' => ['nullable', 'array'],
            'tag.*' => ['nullable', 'string', 'max:255'],
            'access' => ['nullable', 'array'],
            'access.*' => ['nullable', 'integer', 'exists:users,id'],
            'customer_data' => ['nullable', 'in:active,unactive'],
            'order_via_whatsapp' => ['nullable', 'in:instan_rekap,tanya'],
        ], $this->canManageQris() ? [
            'qris' => ['nullable', 'image'],
        ] : []));

        $newdata= new Product();

        $newdata->name = $validated['name'];
        $newdata->slug = Str::slug($newdata->name);
        $newdata->subtitle = $validated['subtitle'] ?? null;
        $newdata->price = $this->normalizeWholeNumberPrice($validated['price'] ?? null);
        $newdata->template_id = $validated['template_id'];
        $newdata->description = $validated['description'] ?? null;
        $newdata->price_prefix = $validated['price_prefix'] ?? null;
        $newdata->address = $validated['address'] ?? null;
        $newdata->no_tlp = $validated['no_tlp'] ?? null;
        $newdata->domain = $this->normalizeDomainUrl($validated['domain'] ?? null);
        $newdata->youtube = $validated['link'] ?? null;
        $newdata->home_button = $validated['home_button'];
        $newdata->customer_data = $validated['customer_data'] ?? 'active';
        $newdata->order_via_whatsapp = $validated['order_via_whatsapp'] ?? 'instan_rekap';
        $newdata->status = 'active';

        if ($request->hasFile('thumbnail')) {
            $newdata->image = $this->storeProductImage($request->file('thumbnail'));
        }

        if ($this->canManageQris() && $request->hasFile('qris')) {
            $newdata->qris = $this->storeQrisImage($request->file('qris'));
        }

        $newdata->qris_status = filled($newdata->qris) ? 'active' : 'unactive';

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
        $this->syncIncompleteHighlightAvailability($product);
        $product->load('productHighlight');

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

        return redirect()
            ->route('product.show', $data)
            ->with('highlight', 'highlight')
            ->with('success', 'Tombol order berhasil diperbarui.');
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

        return redirect()
            ->route('product.show', $data)
            ->with('highlight', 'highlight')
            ->with('success', 'Judul produk berhasil diperbarui.');
    }

    public function productpriceprefix($id, Request $request)
    {
        $validated = $request->validate([
            'price_prefix' => ['nullable', 'string', 'max:255'],
        ]);

        $data = Product::findOrFail($id);
        $this->ensureProductAccess($data);

        $data->price_prefix = $validated['price_prefix'] ?? null;
        $data->save();

        return redirect()
            ->route('product.show', $data)
            ->with('highlight', 'highlight')
            ->with('success', 'Teks sebelum harga berhasil diperbarui.');
    }

    private function buildDomainFileContent(Product $product): string
    {
        $appUrl = rtrim(config('app.url'), '/');
        $detailUrl = $appUrl . '/' . $product->slug . '?domain_preview=1';
        $orderApiUrl = $appUrl . '/api/business/' . $product->slug . '/order';
        $slug = $product->slug;
        $title = addslashes($product->name);

        return <<<PHP
<?php
\$sourceUrl = '{$detailUrl}';
\$originUrl = '{$appUrl}';
\$orderApiUrl = '{$orderApiUrl}';
\$slug = '{$slug}';

function loadRemoteHtml(\$url) {
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

    \$html = @file_get_contents(\$url, false, \$context);
    if (\$html !== false) {
        return [\$html, null];
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
            return [\$response, null];
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

function postFormData(\$url, \$payload) {
    \$body = http_build_query(\$payload);
    \$headers = "Content-Type: application/x-www-form-urlencoded\r\n";
    \$headers .= "Content-Length: " . strlen(\$body) . "\r\n";
    \$headers .= "User-Agent: RekapAjaDomainClient/1.0\r\n";

    \$context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'timeout' => 20,
            'header' => \$headers,
            'content' => \$body,
        ],
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
    ]);

    \$response = @file_get_contents(\$url, false, \$context);
    if (\$response !== false) {
        \$decoded = json_decode(\$response, true);
        if (is_array(\$decoded)) {
            return [\$decoded, null];
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
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => \$body,
            CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
        ]);
        \$result = curl_exec(\$ch);
        \$error = curl_error(\$ch);
        curl_close(\$ch);

        if (\$result !== false) {
            \$decoded = json_decode(\$result, true);
            if (is_array(\$decoded)) {
                return [\$decoded, null];
            }
        }

        return [null, \$error ?: 'Gagal memproses order di server utama.'];
    }

    return [null, 'Hosting tidak mendukung request POST ke server utama.'];
}

if (\$_SERVER['REQUEST_METHOD'] === 'POST' && isset(\$_POST['__mirror_order'])) {
    unset(\$_POST['__mirror_order'], \$_POST['_token']);
    [\$orderResult, \$orderError] = postFormData(\$orderApiUrl, \$_POST);

    if (!empty(\$orderResult['redirect_url'])) {
        header('Location: ' . \$orderResult['redirect_url']);
        exit;
    }

    http_response_code(502);
    echo '<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Gagal Memproses Order</title></head><body style="font-family:Arial,sans-serif;padding:24px;line-height:1.6">';
    echo '<h1>Order tidak dapat diproses.</h1>';
    if (!empty(\$orderResult['message'])) {
        echo '<p><strong>Pesan:</strong> ' . e(\$orderResult['message']) . '</p>';
    }
    if (\$orderError) {
        echo '<p><strong>Detail error:</strong> ' . e(\$orderError) . '</p>';
    }
    echo '</body></html>';
    exit;
}

[ \$html, \$loadError ] = loadRemoteHtml(\$sourceUrl);

if (!is_string(\$html) || trim(\$html) === '') {
    http_response_code(502);
    echo '<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Gagal Memuat Data</title></head><body style="font-family:Arial,sans-serif;padding:24px;line-height:1.6">';
    echo '<h1>Halaman usaha tidak dapat dimuat.</h1>';
    echo '<p>URL sumber yang dicoba: <code>' . e(\$sourceUrl) . '</code></p>';
    if (\$loadError) {
        echo '<p><strong>Detail error:</strong> ' . e(\$loadError) . '</p>';
    }
    echo '<p>Jika ini di hosting shared, biasanya penyebabnya adalah request keluar ke domain utama diblokir, SSL/cURL tidak aktif, atau URL utama belum bisa diakses publik.</p>';
    echo '</body></html>';
    exit;
}
if (stripos(\$html, '<base ') === false) {
    \$html = preg_replace('/<head([^>]*)>/i', '<head$1><base href="' . e(rtrim(\$originUrl, '/') . '/') . '">', \$html, 1);
}

\$origin = rtrim(\$originUrl, '/');
\$patterns = [
    '/(href|src|action)=([\"\'])\\/(?!\\/)/i' => '$1=$2' . \$origin . '/',
    '/(content)=([\"\'])\\/(?!\\/)/i' => '$1=$2' . \$origin . '/',
    '/url\\(\\s*[\"\']?\\/(?!\\/)/i' => 'url(' . \$origin . '/',
];

foreach (\$patterns as \$pattern => \$replacement) {
    \$html = preg_replace(\$pattern, \$replacement, \$html);
}

\$mirrorScript = <<<'SCRIPT'
<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('form[action*="/order/"]').forEach(function (form) {
    form.setAttribute('action', '');
    form.setAttribute('method', 'post');
    form.setAttribute('target', '_self');

    if (!form.querySelector('input[name="__mirror_order"]')) {
      var marker = document.createElement('input');
      marker.type = 'hidden';
      marker.name = '__mirror_order';
      marker.value = '1';
      form.appendChild(marker);
    }
  });
});
</script>
SCRIPT;

if (stripos(\$html, '</body>') !== false) {
    \$html = preg_replace('/<\/body>/i', \$mirrorScript . '</body>', \$html, 1);
} else {
    \$html .= \$mirrorScript;
}

echo \$html;
PHP;
    }

    public function downloadDomainFile(Product $product)
    {
        $this->ensureProductAccess($product);

        $content = $this->buildDomainFileContent($product);

        return response()->streamDownload(function () use ($content) {
            echo $content;
        }, 'index.php', [
            'Content-Type' => 'application/octet-stream',
        ]);
    }

    public function uploadDomainToCpanel(Request $request, Product $product)
    {
        $this->ensureProductAccess($product);

        $validated = $request->validate([
            'subdomain' => ['required', 'string', 'max:63'],
        ]);

        try {
            $subdomain = $this->cpanelDomainPublisher->normalizeSubdomain($validated['subdomain']);
            $result = $this->cpanelDomainPublisher->publish($subdomain, $this->buildDomainFileContent($product));

            $product->domain = $result['url'];
            $product->save();

            return response()->json([
                'message' => $result['subdomain_created']
                    ? 'Subdomain berhasil dibuat dan file berhasil diunggah.'
                    : 'Subdomain sudah ada. File berhasil diunggah ulang.',
                'domain' => $result['url'],
                'subdomain' => $result['subdomain'],
                'document_root' => $result['document_root'],
                'subdomain_created' => $result['subdomain_created'],
            ]);
        } catch (RuntimeException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 422);
        }
    }

    public function browseDomainFolder(Request $request, Product $product)
    {
        $this->ensureProductAccess($product);

        $validated = $request->validate([
            'subdomain' => ['required', 'string', 'max:63'],
        ]);

        try {
            $folder = $this->cpanelDomainPublisher->listDirectoryContents($validated['subdomain']);

            return response()->json([
                'message' => 'Isi folder berhasil dimuat.',
                'document_root' => $folder['document_root'],
                'path' => $folder['path'],
                'entries' => $folder['entries'],
            ]);
        } catch (RuntimeException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'entries' => [],
            ], 422);
        }
    }

    public function updateDomain(Request $request, Product $product)
    {
        $this->ensureProductAccess($product);

        $validated = $request->validate([
            'domain' => ['nullable', 'string', 'max:255', function ($attribute, $value, $fail) {
                if ($value && !$this->normalizeDomainUrl($value)) {
                    $fail('Domain tidak valid.');
                }
            }],
        ]);

        $product->domain = $this->normalizeDomainUrl($validated['domain'] ?? null);
        $product->save();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Domain berhasil disimpan.',
                'domain' => $product->domain,
            ]);
        }

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->ensureProductAccess($product);

        $activeTab = $request->input('active_tab', 'product');

        $validated = $request->validate(array_merge([
            'name' => ['required', 'string', 'max:255', Rule::unique('products', 'name')->ignore($product->id)],
            'subtitle' => ['required', 'string', 'max:255'],
            'price' => ['nullable', 'regex:/^\d+$/'],
            'template_id' => ['required', 'exists:templates,id'],
            'description' => ['required', 'string'],
            'address' => ['nullable', 'string', 'max:255'],
            'no_tlp' => ['nullable', 'string', 'max:20'],
            'domain' => ['nullable', 'string', 'max:255', function ($attribute, $value, $fail) {
                if ($value && !$this->normalizeDomainUrl($value)) {
                    $fail('Domain tidak valid.');
                }
            }],
            'price_prefix' => ['nullable', 'string', 'max:255'],
            'link' => ['nullable', 'url', 'max:255'],
            'home_button' => ['nullable', 'in:on,off'],
            'status' => ['nullable', 'in:active,unactive'],
            'customer_data' => ['nullable', 'in:active,unactive'],
            'order_via_whatsapp' => ['nullable', 'in:instan_rekap,tanya'],
            'thumbnail' => ['nullable', 'image'],
            'category' => ['nullable', 'array'],
            'category.*' => ['nullable', 'string', 'max:255'],
            'tag' => ['nullable', 'array'],
            'tag.*' => ['nullable', 'string', 'max:255'],
            'access' => ['nullable', 'array'],
            'access.*' => ['nullable', 'integer', 'exists:users,id'],
        ], $this->canManageQris() ? [
            'qris' => ['nullable', 'image'],
            'remove_qris' => ['nullable', 'boolean'],
        ] : []));

        $product->name = $validated['name'];
        $product->slug = Str::slug($product->name);
        $product->subtitle = $validated['subtitle'] ?? null;
        $product->price = $this->normalizeWholeNumberPrice($validated['price'] ?? null);
        $product->template_id = $validated['template_id'];
        $product->description = $validated['description'] ?? null;
        $product->price_prefix = $validated['price_prefix'] ?? null;
        $product->address = $validated['address'] ?? null;
        $product->no_tlp = $validated['no_tlp'] ?? null;
        $product->domain = $this->normalizeDomainUrl($validated['domain'] ?? null);
        $product->youtube = $validated['link'] ?? null;

        if (array_key_exists('home_button', $validated)) {
            $product->home_button = $validated['home_button'];
        }

        if (array_key_exists('customer_data', $validated)) {
            $product->customer_data = $validated['customer_data'];
        }

        if (array_key_exists('order_via_whatsapp', $validated)) {
            $product->order_via_whatsapp = $validated['order_via_whatsapp'];
        }

        if (!empty($validated['status'])) {
            $product->status = $validated['status'];
        }

        if ($request->hasFile('thumbnail')) {
            $newImageName = $this->storeProductImage($request->file('thumbnail'));

            $this->deleteImageIfExists($product->image, 'storage/images/product');

            $product->image = $newImageName;
        }

        if ($this->canManageQris()) {
            if ($request->boolean('remove_qris')) {
                $this->deleteImageIfExists($product->qris, 'storage/images/product/qris');
                $product->qris = null;
            }

            if ($request->hasFile('qris')) {
                $newQrisName = $this->storeQrisImage($request->file('qris'));
                $this->deleteImageIfExists($product->qris, 'storage/images/product/qris');
                $product->qris = $newQrisName;
            }

            $product->qris_status = filled($product->qris) ? 'active' : 'unactive';
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
        

        return redirect()
            ->route('product.show', $product)
            ->with('highlight', $activeTab)
            ->with('success', 'Data usaha berhasil disimpan.');
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
