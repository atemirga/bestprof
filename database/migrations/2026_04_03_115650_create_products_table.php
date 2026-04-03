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
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->nullable();
            $table->string('type_label')->nullable();
            $table->text('description')->nullable();
            $table->text('full_description')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->string('price_display')->default('По запросу');
            $table->enum('availability', ['in_stock', 'out_of_stock', 'on_order'])->default('in_stock');
            $table->string('badge')->nullable();
            $table->string('badge_color')->default('#00074B');
            $table->json('specs')->nullable();
            $table->string('hardware')->nullable();
            $table->string('image')->nullable();
            $table->string('card_bg')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
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
