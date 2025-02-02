<?php

namespace Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discount_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // TOTAL_PRICE, CATEGORY_BULK, CATEGORY_CHEAPEST
            $table->json('conditions'); // Koşulları JSON olarak saklayacağız
            $table->decimal('discount_amount', 10, 2)->nullable(); // Sabit indirim miktarı
            $table->decimal('discount_percent', 5, 2)->nullable(); // Yüzdelik indirim
            $table->boolean('is_active')->default(true);
            $table->integer('priority')->default(0); // İndirim uygulama sırası
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discount_rules');
    }
};
