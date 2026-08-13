<?php

namespace App\Http\Controllers;

use App\Services\SeoSitemapService;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __construct(
        private readonly SeoSitemapService $seoSitemapService
    ) {
    }

    public function index(): Response
    {
        $this->seoSitemapService->writeMainSeoFiles();

        return response($this->seoSitemapService->mainSitemapIndexXml(), 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }

    public function pages(): Response
    {
        return response($this->seoSitemapService->mainPagesSitemapXml(), 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }

    public function businesses(): Response
    {
        return response($this->seoSitemapService->mainBusinessesSitemapXml(), 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }
}
