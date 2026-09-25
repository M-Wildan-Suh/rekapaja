<?php

use App\Models\Template;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->json('template_settings')->nullable();
        });

        // Copy each business's existing design, including installations using flat columns.
        DB::table('products')->orderBy('id')->chunkById(100, function ($products) {
            foreach ($products as $product) {
                $settings = Template::defaultSettings();
                $legacy = isset($product->template_id)
                    ? DB::table('templates')->where('id', $product->template_id)->first()
                    : null;
                if ($legacy) {
                    foreach (array_keys($settings) as $section) {
                        $value = json_decode($legacy->{$section} ?? 'null', true);
                        if (is_array($value)) {
                            $settings[$section] = array_replace($settings[$section], $value);
                        }
                    }
                    foreach (Template::SECTION_FIELDS as $field => [$section, $key]) {
                        if (isset($legacy->{$field})) {
                            $settings[$section][$key] = $legacy->{$field};
                        }
                    }
                }
                DB::table('products')->where('id', $product->id)->update([
                    'template_settings' => json_encode($settings),
                ]);
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', fn (Blueprint $table) => $table->dropColumn('template_settings'));
    }
};
