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
use App\Services\SeoSitemapService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use RuntimeException;

class ProductController extends Controller
{
    private const BUSINESS_FIELD_LIMITS = [
        'name' => 100,
        'subtitle' => 120,
        'description' => 1200,
        'address' => 255,
        'no_tlp' => 20,
        'domain' => 255,
        'price_prefix' => 50,
        'product_title' => 255,
        'order_title' => 255,
        'link' => 255,
        'category' => 255,
        'tag' => 255,
    ];

    public function __construct(
        private readonly CpanelDomainPublisher $cpanelDomainPublisher,
        private readonly SeoSitemapService $seoSitemapService
    ) {
    }

    private function productValidationRules(?Product $product = null): array
    {
        return array_merge([
            'name' => [
                'required',
                'string',
                'max:' . self::BUSINESS_FIELD_LIMITS['name'],
                Rule::unique('products', 'name')->ignore($product?->id),
            ],
            'subtitle' => ['required', 'string', 'max:' . self::BUSINESS_FIELD_LIMITS['subtitle']],
            'price' => ['nullable', 'regex:/^\d+$/'],
            'template_id' => ['required', 'exists:templates,id'],
            'description' => ['required', 'string', 'max:' . self::BUSINESS_FIELD_LIMITS['description']],
            'address' => ['nullable', 'string', 'max:' . self::BUSINESS_FIELD_LIMITS['address']],
            'no_tlp' => ['nullable', 'string', 'max:' . self::BUSINESS_FIELD_LIMITS['no_tlp']],
            'domain' => ['nullable', 'string', 'max:' . self::BUSINESS_FIELD_LIMITS['domain'], function ($attribute, $value, $fail) {
                if ($value && !$this->normalizeDomainUrl($value)) {
                    $fail('Domain tidak valid.');
                }
            }],
            'price_prefix' => ['nullable', 'string', 'max:' . self::BUSINESS_FIELD_LIMITS['price_prefix']],
            'product_title' => ['nullable', 'string', 'max:' . self::BUSINESS_FIELD_LIMITS['product_title']],
            'order_title' => ['nullable', 'string', 'max:' . self::BUSINESS_FIELD_LIMITS['order_title']],
            'link' => ['nullable', 'url', 'max:' . self::BUSINESS_FIELD_LIMITS['link']],
            'category' => ['nullable', 'array'],
            'category.*' => ['nullable', 'string', 'max:' . self::BUSINESS_FIELD_LIMITS['category']],
            'tag' => ['nullable', 'array'],
            'tag.*' => ['nullable', 'string', 'max:' . self::BUSINESS_FIELD_LIMITS['tag']],
            'access' => ['nullable', 'integer', 'exists:users,id'],
        ], $this->canManageQris() ? [
            'qris' => ['nullable', 'image'],
        ] : []);
    }

    private function productValidationMessages(): array
    {
        return [
            'name.max' => 'Nama usaha maksimal ' . self::BUSINESS_FIELD_LIMITS['name'] . ' karakter.',
            'subtitle.max' => 'Tagline maksimal ' . self::BUSINESS_FIELD_LIMITS['subtitle'] . ' karakter.',
            'description.max' => 'Deskripsi usaha maksimal ' . self::BUSINESS_FIELD_LIMITS['description'] . ' karakter.',
            'address.max' => 'Alamat maksimal ' . self::BUSINESS_FIELD_LIMITS['address'] . ' karakter.',
            'no_tlp.max' => 'Nomor WhatsApp maksimal ' . self::BUSINESS_FIELD_LIMITS['no_tlp'] . ' karakter.',
            'domain.max' => 'Domain maksimal ' . self::BUSINESS_FIELD_LIMITS['domain'] . ' karakter.',
            'price_prefix.max' => 'Prefix harga maksimal ' . self::BUSINESS_FIELD_LIMITS['price_prefix'] . ' karakter.',
            'product_title.max' => 'Judul produk maksimal ' . self::BUSINESS_FIELD_LIMITS['product_title'] . ' karakter.',
            'order_title.max' => 'Teks tombol order maksimal ' . self::BUSINESS_FIELD_LIMITS['order_title'] . ' karakter.',
            'link.max' => 'Link YouTube maksimal ' . self::BUSINESS_FIELD_LIMITS['link'] . ' karakter.',
            'category.*.max' => 'Nama kategori maksimal ' . self::BUSINESS_FIELD_LIMITS['category'] . ' karakter.',
            'tag.*.max' => 'Nama tag maksimal ' . self::BUSINESS_FIELD_LIMITS['tag'] . ' karakter.',
        ];
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

        $ownedProductId = Access::where('user_id', Auth::id())
            ->oldest('id')
            ->value('product_id');

        abort_unless((int) $ownedProductId === $product->id, 403);
    }

    private function availableAccessUsers(?Product $product = null)
    {
        $assignedUserIds = Access::query()
            ->when($product, fn ($query) => $query->where('product_id', '!=', $product->id))
            ->pluck('user_id');

        return User::whereNotIn('role', ['admin', 'superadmin'])
            ->whereNotIn('id', $assignedUserIds)
            ->orderBy('name')
            ->get();
    }

    private function ensureOwnerIsAvailable(int $userId, ?Product $product = null): void
    {
        $ownerExists = User::whereKey($userId)
            ->whereNotIn('role', ['admin', 'superadmin'])
            ->exists();

        $ownerHasAnotherBusiness = Access::where('user_id', $userId)
            ->when($product, fn ($query) => $query->where('product_id', '!=', $product->id))
            ->exists();

        if (!$ownerExists) {
            throw ValidationException::withMessages([
                'access' => 'Pilih akun pemilik yang valid.',
            ]);
        }

        if ($ownerHasAnotherBusiness) {
            throw ValidationException::withMessages([
                'access' => 'Akun ini sudah terhubung dengan usaha lain.',
            ]);
        }
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

        if (in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            $data = Product::all();
        } else {
            $productId = Access::where('user_id', Auth::id())->oldest('id')->value('product_id');

            if (!$productId) {
                return view('dashboard', ['data' => collect(), 'no_tlp' => $no_tlp]);
            }

            return redirect()->route('product.show', $productId);
        }

        return view('dashboard', compact('data', 'no_tlp'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect()->route('dashboard');
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
        $accessUsers = $this->availableAccessUsers();

        return view('admin.product.create', compact('tag', 'template', 'product', 'category', 'accessUsers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate(array_merge($this->productValidationRules(), [
            'home_button' => ['required', 'in:on,off'],
            'product_title' => ['required', 'string', 'max:' . self::BUSINESS_FIELD_LIMITS['product_title']],
            'order_title' => ['required', 'string', 'max:' . self::BUSINESS_FIELD_LIMITS['order_title']],
            'thumbnail' => ['required', 'image'],
            'customer_data' => ['nullable', 'in:active,unactive'],
            'order_via_whatsapp' => ['nullable', 'in:instan_rekap,tanya'],
        ]), $this->productValidationMessages());

        $ownerId = $validated['access'] ?? null;

        if ($ownerId) {
            $this->ensureOwnerIsAvailable((int) $ownerId);
        }

        $newdata= new Product();

        $newdata->name = $validated['name'];
        $newdata->slug = Str::slug($newdata->name);
        $newdata->subtitle = $validated['subtitle'] ?? null;
        $newdata->price = $this->normalizeWholeNumberPrice($validated['price'] ?? null);
        $newdata->template_id = $validated['template_id'];
        $newdata->description = $validated['description'] ?? null;
        $newdata->price_prefix = $validated['price_prefix'] ?? null;
        $newdata->product_title = $validated['product_title'];
        $newdata->order_title = $validated['order_title'];
        $newdata->address = $validated['address'] ?? null;
        $newdata->no_tlp = $validated['no_tlp'] ?? null;
        $newdata->domain = $this->normalizeDomainUrl($validated['domain'] ?? null);
        $newdata->youtube = $validated['link'] ?? null;
        $newdata->home_button = $validated['home_button'];
        $newdata->customer_data = $validated['customer_data'] ?? 'unactive';
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

        if ($ownerId) {
            Access::create([
                'user_id' => $ownerId,
                'product_id' => $newdata->id,
            ]);
        }
          
        return redirect()->route('product.index')->with('success', 'Usaha berhasil ditambahkan.');
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
        $accessUsers = $this->availableAccessUsers($product);
        
        return view('admin.product.edit', compact('product', 'tag', 'template', 'category', 'data', 'accessUsers'));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    private function buildDomainFileContent(Product $product): string
    {
        $appUrl = rtrim(config('app.url'), '/');
        $detailUrl = route('domain.preview', ['product' => $product->id]) . '?domain_preview=1';
        $orderApiUrl = route('api.business.id.order', ['product' => $product->id]);
        $title = addslashes($product->name);

        return <<<PHP
<?php
\$sourceUrl = '{$detailUrl}';
\$originUrl = '{$appUrl}';
\$orderApiUrl = '{$orderApiUrl}';

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

    private function buildDomainSeoFiles(Product $product, string $publicUrl): array
    {
        return [
            'sitemap.xml' => $this->seoSitemapService->businessSitemapXml($product, $publicUrl),
            'robots.txt' => $this->seoSitemapService->businessRobotsTxt($product, $publicUrl),
        ];
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
            $publicUrl = $this->cpanelDomainPublisher->buildPublicUrl($subdomain);
            $result = $this->cpanelDomainPublisher->publishFiles($subdomain, array_merge([
                'index.php' => $this->buildDomainFileContent($product),
            ], $this->buildDomainSeoFiles($product, $publicUrl)));

            $product->domain = $result['url'];
            $product->save();

            return response()->json([
                'message' => $result['subdomain_created']
                    ? 'Subdomain berhasil dibuat dan file website + sitemap berhasil diunggah.'
                    : 'Subdomain sudah ada. File website + sitemap berhasil diunggah ulang.',
                'domain' => $result['url'],
                'subdomain' => $result['subdomain'],
                'document_root' => $result['document_root'],
                'subdomain_created' => $result['subdomain_created'],
                'files' => $result['files'] ?? [],
            ]);
        } catch (RuntimeException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 422);
        }
    }

    public function uploadDomainSitemap(Request $request, Product $product)
    {
        $this->ensureProductAccess($product);

        $validated = $request->validate([
            'subdomain' => ['required', 'string', 'max:63'],
        ]);

        try {
            $subdomain = $this->cpanelDomainPublisher->normalizeSubdomain($validated['subdomain']);
            $publicUrl = $this->cpanelDomainPublisher->buildPublicUrl($subdomain);
            $result = $this->cpanelDomainPublisher->publishFiles($subdomain, $this->buildDomainSeoFiles($product, $publicUrl));

            $product->domain = $result['url'];
            $product->save();

            return response()->json([
                'message' => 'Sitemap.xml dan robots.txt berhasil diunggah ke subdomain.',
                'domain' => $result['url'],
                'subdomain' => $result['subdomain'],
                'document_root' => $result['document_root'],
                'files' => $result['files'] ?? [],
            ]);
        } catch (RuntimeException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 422);
        }
    }

    public function uploadCustomDomainSitemap(Request $request, Product $product)
    {
        $this->ensureProductAccess($product);

        $validated = $request->validate([
            'domain' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
                if (!$this->normalizeDomainUrl($value)) {
                    $fail('Domain custom tidak valid.');
                }
            }],
        ]);

        try {
            $normalizedDomain = $this->normalizeDomainUrl($validated['domain']);
            $domainHost = parse_url((string) $normalizedDomain, PHP_URL_HOST) ?: '';

            if ($domainHost === '') {
                throw new RuntimeException('Domain custom tidak valid.');
            }

            $result = $this->cpanelDomainPublisher->publishCustomDomain($domainHost, $this->buildDomainSeoFiles($product, 'https://' . $domainHost));

            $product->domain = $result['url'];
            $product->save();

            return response()->json([
                'message' => 'Sitemap.xml dan robots.txt berhasil diunggah ke custom domain.',
                'domain' => $result['url'],
                'document_root' => $result['document_root'],
                'files' => $result['files'] ?? [],
            ]);
        } catch (RuntimeException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 422);
        }
    }

    public function uploadCustomDomainToCpanel(Request $request, Product $product)
    {
        $this->ensureProductAccess($product);

        $validated = $request->validate([
            'domain' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
                if (!$this->normalizeDomainUrl($value)) {
                    $fail('Domain custom tidak valid.');
                }
            }],
        ]);

        try {
            $normalizedDomain = $this->normalizeDomainUrl($validated['domain']);
            $domainHost = parse_url((string) $normalizedDomain, PHP_URL_HOST) ?: '';

            if ($domainHost === '') {
                throw new RuntimeException('Domain custom tidak valid.');
            }

            $result = $this->cpanelDomainPublisher->publishCustomDomain($domainHost, array_merge([
                'index.php' => $this->buildDomainFileContent($product),
            ], $this->buildDomainSeoFiles($product, 'https://' . $domainHost)));

            $product->domain = $result['url'];
            $product->save();

            return response()->json([
                'message' => 'Custom domain berhasil dipasang di cPanel dan file website + sitemap berhasil diunggah. Pastikan DNS domain mengarah ke server hosting ini.',
                'domain' => $result['url'],
                'document_root' => $result['document_root'],
                'files' => $result['files'] ?? [],
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
            'type' => ['required', 'in:subdomain,custom'],
            'subdomain' => ['nullable', 'string', 'max:63'],
            'domain' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            $folder = $validated['type'] === 'custom'
                ? $this->cpanelDomainPublisher->listCustomDomainContents((string) $validated['domain'])
                : $this->cpanelDomainPublisher->listDirectoryContents((string) $validated['subdomain']);

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

        $validated = $request->validate(array_merge($this->productValidationRules($product), [
            'home_button' => ['nullable', 'in:on,off'],
            'status' => ['nullable', 'in:active,unactive'],
            'customer_data' => ['nullable', 'in:active,unactive'],
            'order_via_whatsapp' => ['nullable', 'in:instan_rekap,tanya'],
            'thumbnail' => ['nullable', 'image'],
        ], $this->canManageQris() ? [
            'remove_qris' => ['nullable', 'boolean'],
        ] : []), $this->productValidationMessages());

        $product->name = $validated['name'];
        $product->slug = Str::slug($product->name);
        $product->subtitle = $validated['subtitle'] ?? null;
        $product->price = $this->normalizeWholeNumberPrice($validated['price'] ?? null);
        $product->template_id = $validated['template_id'];
        $product->description = $validated['description'] ?? null;
        $product->price_prefix = $validated['price_prefix'] ?? null;
        $product->product_title = $validated['product_title'] ?? $product->product_title;
        $product->order_title = $validated['order_title'] ?? $product->order_title;
        $product->address = $validated['address'] ?? null;
        $product->no_tlp = $validated['no_tlp'] ?? null;
        if (array_key_exists('domain', $validated)) {
            $product->domain = $this->normalizeDomainUrl($validated['domain']);
        }
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

        if (in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            $ownerId = $validated['access'] ?? null;

            if ($ownerId) {
                $this->ensureOwnerIsAvailable((int) $ownerId, $product);
            }

            Access::where('product_id', $product->id)->delete();

            if ($ownerId) {
                Access::create([
                    'user_id' => $ownerId,
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

        return redirect()->back()->with('success', 'Usaha beserta gambar galerinya berhasil dihapus.');
    }
}
