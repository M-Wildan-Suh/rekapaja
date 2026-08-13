<?php

namespace App\Console\Commands;

use App\Services\SeoSitemapService;
use Illuminate\Console\Command;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap.xml, child sitemaps, and robots.txt for the main website';

    public function __construct(
        private readonly SeoSitemapService $seoSitemapService
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->seoSitemapService->writeMainSeoFiles();

        $this->info('SEO files generated: sitemap.xml, sitemaps/pages.xml, sitemaps/businesses.xml, robots.txt');
    }
}
