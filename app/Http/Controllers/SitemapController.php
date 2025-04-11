<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Str;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = Sitemap::create()
            ->add(Url::create('/')->setLastModificationDate(now()))
            ->add(Url::create('/bisnis')->setLastModificationDate(now()));

        // Dynamically add more URLs if needed, such as from a database
        foreach (Product::where('status', 'active')->get() as $model) {
            $slug = Str::slug($model->name, '-');
            $sitemap->add(Url::create("/{$slug}")->setLastModificationDate($model->updated_at));
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));
        // return response()->download(public_path('sitemap.xml'));
        return redirect('/sitemap.xml');
    }
}

