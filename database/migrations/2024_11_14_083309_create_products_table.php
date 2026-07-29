<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('image');
            $table->string('youtube')->nullable();
            $table->string('template')->default('one');
            $table->string('product_title')->default('Produk Kami');
            $table->string('order_title')->default('beli');
            $table->string('price_prefix')->nullable();
            $table->integer('price')->nullable();
            $table->string('address')->nullable();
            $table->string('no_tlp')->nullable();
            $table->string('qris')->nullable();
            $table->string('domain')->nullable();
            $table->string('status')->default('unactive');
            $table->enum('customer_data', ['active', 'unactive'])->default('active');
            $table->enum('qris_status', ['active', 'unactive'])->default('active');
            $table->enum('order_via_whatsapp', ['instan_rekap', 'tanya'])->default('instan_rekap');
            $table->longText('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
