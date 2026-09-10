<?php

namespace Tests;

use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

abstract class VoucherTestCase extends TestCase
{
    protected string $imageRoot;

    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        // The unrelated invoice alteration requires DBAL on SQLite.
        foreach (glob(database_path('migrations/*.php')) as $migration) {
            if (basename($migration) !== '2026_08_21_000001_add_status_to_invoices_table.php') {
                (require $migration)->up();
            }
        }
        // These existing production columns predate the repository's migrations.
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('template_id')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('home_button')->default('on');
        });
        $this->imageRoot = storage_path('framework/testing/voucher-'.Str::uuid());
        $this->app->usePublicPath($this->imageRoot);
        File::ensureDirectoryExists($this->imageRoot.'/storage/images/product');
        file_put_contents($this->imageRoot.'/storage/images/product/source.webp', 'test image');
        $this->withoutVite();
    }

    protected function tearDown(): void
    {
        if (isset($this->imageRoot)) {
            File::deleteDirectory($this->imageRoot);
        }
        parent::tearDown();
    }

    protected function voucher(array $attributes = []): Voucher
    {
        $source = new Product;
        $source->forceFill([
            'name' => 'Usaha '.Str::random(8), 'slug' => Str::random(12),
            'image' => 'source.webp', 'description' => 'Deskripsi usaha',
            'domain' => 'https://source.example.com', 'qris' => 'source-qris.webp',
            'qris_status' => 'active', 'customer_data' => 'unactive', 'status' => 'active',
        ])->save();

        return Voucher::create(array_merge([
            'code' => Str::upper(Str::random(16)), 'product_id' => $source->id,
            'role' => 'premium', 'premium_type' => 'year', 'expired' => now()->addYear()->toDateString(),
        ], $attributes));
    }
}
