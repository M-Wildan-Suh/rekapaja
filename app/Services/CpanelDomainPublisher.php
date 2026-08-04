<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class CpanelDomainPublisher
{
    public function isConfigured(): bool
    {
        return filled(config('services.cpanel.base_url'))
            && filled(config('services.cpanel.username'))
            && filled(config('services.cpanel.api_token'))
            && filled(config('services.cpanel.parent_domain'))
            && filled(config('services.cpanel.home_directory'));
    }

    public function parentDomain(): string
    {
        return (string) config('services.cpanel.parent_domain', 'rekapaja.com');
    }

    public function normalizeSubdomain(string $subdomain): string
    {
        $subdomain = strtolower(trim($subdomain));

        if (!preg_match('/^(?!-)[a-z0-9-]{1,63}(?<!-)$/', $subdomain)) {
            throw new RuntimeException('Subdomain tidak valid. Gunakan huruf kecil, angka, atau tanda minus.');
        }

        return $subdomain;
    }

    public function buildPublicUrl(string $subdomain): string
    {
        return 'https://' . $this->normalizeSubdomain($subdomain) . '.' . $this->parentDomain();
    }

    public function publish(string $subdomain, string $fileContent): array
    {
        if (!$this->isConfigured()) {
            throw new RuntimeException('Konfigurasi cPanel belum lengkap di file .env.');
        }

        $subdomain = $this->normalizeSubdomain($subdomain);
        $parentDomain = $this->parentDomain();
        $requestedDocumentRoot = $this->documentRootForSubdomain($subdomain);

        $subdomainResult = $this->createSubdomain($subdomain, $parentDomain, $requestedDocumentRoot);
        $documentRoot = $subdomainResult['document_root'];

        $this->saveFile($documentRoot, 'index.php', $fileContent);

        return [
            'url' => $this->buildPublicUrl($subdomain),
            'document_root' => $documentRoot,
            'subdomain' => $subdomain,
            'subdomain_created' => $subdomainResult['created'],
        ];
    }

    public function listDirectoryContents(string $subdomain): array
    {
        if (!$this->isConfigured()) {
            throw new RuntimeException('Konfigurasi cPanel belum lengkap di file .env.');
        }

        $subdomain = $this->normalizeSubdomain($subdomain);
        $subdomainInfo = $this->findSubdomain($subdomain);
        $documentRoot = $subdomainInfo['document_root'] ?? $this->documentRootForSubdomain($subdomain);
        $fullPath = $subdomainInfo['full_path'] ?? $this->fullDirectoryPath($documentRoot);

        $response = $this->api2('Fileman', 'listfiles', [
            'dir' => $fullPath,
            'filepath' => $fullPath,
            'needmime' => 1,
            'types' => 'dir|file',
        ]);

        $result = (int) data_get($response, 'cpanelresult.event.result', 0);
        $reason = (string) (data_get($response, 'cpanelresult.error')
            ?? data_get($response, 'cpanelresult.data.0.reason')
            ?? '');

        if ($result !== 1 && $reason !== '') {
            throw new RuntimeException($reason);
        }

        $rows = data_get($response, 'cpanelresult.data', []);
        $entries = collect(is_array($rows) ? $rows : [])
            ->filter(fn ($item) => is_array($item))
            ->map(function (array $item) {
                $name = (string) ($item['file'] ?? $item['name'] ?? $item['filename'] ?? '');
                $type = strtolower((string) ($item['type'] ?? $item['filetype'] ?? 'file'));
                $isDirectory = str_contains($type, 'dir');

                return [
                    'name' => $name,
                    'type' => $isDirectory ? 'dir' : 'file',
                    'size' => (string) ($item['humansize'] ?? $item['size'] ?? ''),
                    'modified_at' => (string) ($item['mtime'] ?? $item['modified'] ?? $item['date'] ?? ''),
                ];
            })
            ->filter(fn (array $item) => $item['name'] !== '' && $item['name'] !== '.' && $item['name'] !== '..')
            ->values()
            ->all();

        return [
            'document_root' => $documentRoot,
            'path' => $fullPath,
            'entries' => $entries,
        ];
    }

    private function documentRootForSubdomain(string $subdomain): string
    {
        return $this->normalizeSubdomain($subdomain) . '.' . $this->parentDomain();
    }

    private function fullDirectoryPath(string $documentRoot): string
    {
        return rtrim((string) config('services.cpanel.home_directory'), '/') . '/' . trim($documentRoot, '/');
    }

    private function createSubdomain(string $subdomain, string $parentDomain, string $documentRoot): array
    {
        $response = $this->api2('SubDomain', 'addsubdomain', [
            'domain' => $subdomain,
            'rootdomain' => $parentDomain,
            'dir' => $documentRoot,
        ]);

        $result = (int) data_get($response, 'cpanelresult.event.result', 0);
        $reason = (string) (data_get($response, 'cpanelresult.error')
            ?? data_get($response, 'cpanelresult.data.0.reason')
            ?? '');
        $reasonLower = strtolower($reason);

        if ($result === 1) {
            return [
                'created' => true,
                'document_root' => $documentRoot,
            ];
        }

        if (!str_contains($reasonLower, 'already exists')) {
            throw new RuntimeException($reason !== '' ? $reason : 'Gagal membuat subdomain di cPanel.');
        }

        $existing = $this->findSubdomain($subdomain);

        return [
            'created' => false,
            'document_root' => $existing['document_root'] ?? $documentRoot,
        ];
    }

    private function findSubdomain(string $subdomain): ?array
    {
        $subdomain = $this->normalizeSubdomain($subdomain);
        $fullDomain = $subdomain . '.' . $this->parentDomain();

        $response = $this->api2('SubDomain', 'listsubdomains', [
            'regex' => '^' . preg_quote($fullDomain, '/') . '$',
            'return_https_redirect_status' => 1,
        ]);

        $result = (int) data_get($response, 'cpanelresult.event.result', 0);
        if ($result !== 1) {
            return null;
        }

        $items = data_get($response, 'cpanelresult.data', []);
        if (!is_array($items)) {
            return null;
        }

        foreach ($items as $item) {
            if (!is_array($item)) {
                continue;
            }

            if (strtolower((string) ($item['domain'] ?? '')) !== strtolower($fullDomain)) {
                continue;
            }

            $fullPath = (string) ($item['dir'] ?? '');
            $documentRoot = trim((string) ($item['basedir'] ?? ''), '/');

            if ($documentRoot === '' && $fullPath !== '') {
                $homeDirectory = rtrim((string) config('services.cpanel.home_directory'), '/');
                $prefix = $homeDirectory . '/';
                $documentRoot = str_starts_with($fullPath, $prefix)
                    ? trim(substr($fullPath, strlen($prefix)), '/')
                    : trim($fullPath, '/');
            }

            return [
                'domain' => $fullDomain,
                'document_root' => $documentRoot,
                'full_path' => $fullPath !== '' ? $fullPath : $this->fullDirectoryPath($documentRoot),
            ];
        }

        return null;
    }

    private function saveFile(string $documentRoot, string $filename, string $content): void
    {
        $homeDirectory = rtrim((string) config('services.cpanel.home_directory'), '/');
        $fullPath = $this->fullDirectoryPath($documentRoot);
        $expectedPath = $fullPath . '/' . ltrim($filename, '/');

        $mkdirResponse = $this->api2('Fileman', 'mkdir', [
            'path' => $homeDirectory,
            'name' => trim($documentRoot, '/'),
            'permissions' => '0755',
        ]);

        $mkdirResult = (int) data_get($mkdirResponse, 'cpanelresult.event.result', 0);
        $mkdirReason = strtolower((string) (data_get($mkdirResponse, 'cpanelresult.error')
            ?? data_get($mkdirResponse, 'cpanelresult.data.0.reason')
            ?? ''));

        if ($mkdirResult !== 1 && !str_contains($mkdirReason, 'exists')) {
            throw new RuntimeException($mkdirReason !== '' ? $mkdirReason : 'Gagal menyiapkan folder subdomain di cPanel.');
        }

        $response = $this->api2Post('Fileman', 'savefile', [
            'path' => $fullPath,
            'filename' => $filename,
            'content' => $content,
        ]);

        $result = (int) data_get($response, 'cpanelresult.event.result', 0);
        $reason = (string) (data_get($response, 'cpanelresult.error')
            ?? data_get($response, 'cpanelresult.data.0.reason')
            ?? '');
        $savedPath = (string) (data_get($response, 'cpanelresult.data.0.path') ?? '');

        if ($result !== 1 || $reason !== '') {
            Log::error('cPanel savefile failed.', [
                'path' => $fullPath,
                'filename' => $filename,
                'reason' => $reason,
                'response' => $response,
            ]);

            throw new RuntimeException($reason !== '' ? $reason : 'Gagal mengunggah file ke cPanel.');
        }

        if ($savedPath !== '' && !$this->pathsMatch($savedPath, $expectedPath)) {
            Log::warning('cPanel savefile wrote to unexpected path. Retrying with file move.', [
                'expected_path' => $expectedPath,
                'actual_path' => $savedPath,
            ]);

            $fallbackResponse = $this->api2('Fileman', 'fileop', [
                'op' => 'move',
                'sourcefiles' => ltrim($filename, '/'),
                'destfiles' => trim($documentRoot, '/'),
                'doubledecode' => 1,
            ]);

            $fallbackResult = (int) data_get($fallbackResponse, 'cpanelresult.event.result', 0);
            $fallbackReason = (string) (data_get($fallbackResponse, 'cpanelresult.error')
                ?? data_get($fallbackResponse, 'cpanelresult.data.0.reason')
                ?? '');
            $fallbackSavedPath = (string) (data_get($fallbackResponse, 'cpanelresult.data.0.dest') ?? '');

            if ($fallbackResult !== 1 || $fallbackReason !== '' || ($fallbackSavedPath !== '' && !$this->pathsMatch($fallbackSavedPath, $fullPath))) {
                Log::error('cPanel savefile fallback failed.', [
                    'expected_path' => $expectedPath,
                    'fallback_saved_path' => $fallbackSavedPath,
                    'reason' => $fallbackReason,
                    'response' => $fallbackResponse,
                ]);

                throw new RuntimeException($fallbackReason !== '' ? $fallbackReason : 'Gagal mengunggah file ke folder subdomain yang benar.');
            }

            Log::info('cPanel savefile fallback succeeded.', [
                'expected_path' => $expectedPath,
                'saved_path' => $fallbackSavedPath,
                'response' => $fallbackResponse,
            ]);

            $verification = $this->api2('Fileman', 'listfiles', [
                'dir' => $fullPath,
                'filepath' => $fullPath . '/' . ltrim($filename, '/'),
                'needmime' => 1,
                'types' => 'file',
            ]);

            $verificationEntries = data_get($verification, 'cpanelresult.data', []);
            $foundFile = collect(is_array($verificationEntries) ? $verificationEntries : [])
                ->contains(fn ($item) => is_array($item) && (($item['file'] ?? $item['name'] ?? $item['filename'] ?? '') === ltrim($filename, '/')));

            if (!$foundFile) {
                Log::error('Moved file could not be verified in target directory.', [
                    'expected_path' => $expectedPath,
                    'verification_response' => $verification,
                ]);

                throw new RuntimeException('File berhasil dipindah oleh cPanel, tetapi belum terverifikasi di folder subdomain.');
            }

            return;
        }

        Log::info('cPanel savefile succeeded.', [
            'path' => $fullPath,
            'filename' => $filename,
            'response' => $response,
        ]);
    }

    private function pathsMatch(string $left, string $right): bool
    {
        return rtrim(str_replace('\\', '/', $left), '/') === rtrim(str_replace('\\', '/', $right), '/');
    }

    private function api2(string $module, string $function, array $params): array
    {
        return $this->sendApi2Request('GET', $module, $function, $params);
    }

    private function api2Post(string $module, string $function, array $params): array
    {
        return $this->sendApi2Request('POST', $module, $function, $params);
    }

    private function sendApi2Request(string $method, string $module, string $function, array $params): array
    {
        $request = Http::withHeaders([
            'Authorization' => 'cpanel ' . config('services.cpanel.username') . ':' . config('services.cpanel.api_token'),
            'Accept' => 'application/json',
        ])->timeout(30);

        $url = rtrim((string) config('services.cpanel.base_url'), '/') . '/json-api/cpanel';
        $payload = array_merge([
            'cpanel_jsonapi_user' => config('services.cpanel.username'),
            'cpanel_jsonapi_apiversion' => 2,
            'cpanel_jsonapi_module' => $module,
            'cpanel_jsonapi_func' => $function,
        ], $params);

        $response = $method === 'POST'
            ? $request->asForm()->post($url, $payload)
            : $request->get($url, $payload);

        if (!$response->successful()) {
            Log::error('cPanel API request failed.', [
                'method' => $method,
                'module' => $module,
                'function' => $function,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            throw new RuntimeException('Gagal terhubung ke cPanel. HTTP ' . $response->status() . '.');
        }

        return $response->json() ?? [];
    }
}
