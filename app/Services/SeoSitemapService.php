<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Carbon\CarbonInterface;

class SeoSitemapService
{
    public function normalizedAppUrl(): string
    {
        return rtrim((string) config('app.url'), '/');
    }

    public function normalizeUrl(?string $url): ?string
    {
        $url = trim((string) $url);

        if ($url === '') {
            return null;
        }

        if (!preg_match('~^https?://~i', $url)) {
            $url = 'https://' . $url;
        }

        $parts = parse_url($url);
        if (!$parts || empty($parts['host'])) {
            return null;
        }

        $scheme = strtolower($parts['scheme'] ?? 'https');
        if (!in_array($scheme, ['http', 'https'], true)) {
            return null;
        }

        $normalized = $scheme . '://' . strtolower((string) $parts['host']);

        if (!empty($parts['port'])) {
            $normalized .= ':' . $parts['port'];
        }

        if (!empty($parts['path']) && $parts['path'] !== '/') {
            $normalized .= '/' . trim((string) $parts['path'], '/');
        }

        return rtrim($normalized, '/');
    }

    public function productPublicUrl(Product $product): string
    {
        return $this->normalizeUrl($product->domain) ?: route('detail', ['slug' => $product->slug]);
    }

    public function shouldLiveOnMainDomain(Product $product): bool
    {
        return blank($this->normalizeUrl($product->domain));
    }

    public function mainSitemapIndexXml(): string
    {
        return $this->renderSitemapIndex([
            $this->normalizedAppUrl() . '/sitemaps/pages.xml',
            $this->normalizedAppUrl() . '/sitemaps/businesses.xml',
        ]);
    }

    public function mainPagesSitemapXml(): string
    {
        $entries = [
            $this->makeEntry($this->normalizedAppUrl() . '/', now(), 'daily', '1.0'),
            $this->makeEntry(route('allproduct'), now(), 'daily', '0.9'),
            $this->makeEntry(route('alltemplate'), now(), 'weekly', '0.7'),
            $this->makeEntry(route('join'), now(), 'weekly', '0.7'),
            $this->makeEntry(route('premium.package'), now(), 'weekly', '0.7'),
        ];

        Category::query()
            ->whereHas('products', fn ($query) => $query->where('status', 'active'))
            ->get()
            ->each(function (Category $category) use (&$entries) {
                $entries[] = $this->makeEntry(
                    route('category.business', ['category' => strtolower($category->category)]),
                    $category->updated_at ?? now(),
                    'weekly',
                    '0.6'
                );
            });

        return $this->renderUrlSet($entries);
    }

    public function mainBusinessesSitemapXml(): string
    {
        $entries = Product::query()
            ->where('status', 'active')
            ->get()
            ->filter(fn (Product $product) => $this->shouldLiveOnMainDomain($product))
            ->map(fn (Product $product) => $this->makeEntry(
                route('detail', ['slug' => $product->slug]),
                $product->updated_at,
                'weekly',
                '0.8'
            ))
            ->values()
            ->all();

        return $this->renderUrlSet($entries);
    }

    public function businessSitemapXml(Product $product, ?string $publicUrl = null): string
    {
        $publicUrl = rtrim($publicUrl ?: $this->productPublicUrl($product), '/');

        return $this->renderUrlSet([
            $this->makeEntry($publicUrl, $product->updated_at, 'weekly', '0.9'),
        ]);
    }

    public function mainRobotsTxt(): string
    {
        return $this->renderRobotsTxt($this->normalizedAppUrl() . '/sitemap.xml');
    }

    public function businessRobotsTxt(Product $product, ?string $publicUrl = null): string
    {
        $publicUrl = rtrim($publicUrl ?: $this->productPublicUrl($product), '/');

        return $this->renderRobotsTxt($publicUrl . '/sitemap.xml');
    }

    public function writeMainSeoFiles(): void
    {
        $sitemapDirectory = public_path('sitemaps');

        if (!is_dir($sitemapDirectory)) {
            mkdir($sitemapDirectory, 0755, true);
        }

        file_put_contents(public_path('sitemap.xml'), $this->mainSitemapIndexXml());
        file_put_contents($sitemapDirectory . '/pages.xml', $this->mainPagesSitemapXml());
        file_put_contents($sitemapDirectory . '/businesses.xml', $this->mainBusinessesSitemapXml());
        file_put_contents(public_path('robots.txt'), $this->mainRobotsTxt());
    }

    private function makeEntry(string $loc, CarbonInterface $lastModified, string $changeFrequency, string $priority): array
    {
        return [
            'loc' => $loc,
            'lastmod' => $lastModified->toAtomString(),
            'changefreq' => $changeFrequency,
            'priority' => $priority,
        ];
    }

    private function renderUrlSet(array $entries): string
    {
        $lines = [
            '<?xml version="1.0" encoding="UTF-8"?>',
            '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">',
        ];

        foreach ($entries as $entry) {
            $lines[] = '  <url>';
            $lines[] = '    <loc>' . e($entry['loc']) . '</loc>';
            $lines[] = '    <lastmod>' . e($entry['lastmod']) . '</lastmod>';
            $lines[] = '    <changefreq>' . e($entry['changefreq']) . '</changefreq>';
            $lines[] = '    <priority>' . e($entry['priority']) . '</priority>';
            $lines[] = '  </url>';
        }

        $lines[] = '</urlset>';

        return implode("\n", $lines) . "\n";
    }

    private function renderSitemapIndex(array $locations): string
    {
        $timestamp = now()->toAtomString();

        $lines = [
            '<?xml version="1.0" encoding="UTF-8"?>',
            '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">',
        ];

        foreach ($locations as $location) {
            $lines[] = '  <sitemap>';
            $lines[] = '    <loc>' . e($location) . '</loc>';
            $lines[] = '    <lastmod>' . e($timestamp) . '</lastmod>';
            $lines[] = '  </sitemap>';
        }

        $lines[] = '</sitemapindex>';

        return implode("\n", $lines) . "\n";
    }

    private function renderRobotsTxt(string $sitemapUrl): string
    {
        return implode("\n", [
            'User-agent: *',
            'Allow: /',
            '',
            'Sitemap: ' . $sitemapUrl,
            '',
        ]);
    }
}
