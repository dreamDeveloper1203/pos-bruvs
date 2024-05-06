<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('image_path')->nullable();
            $table->string('name');
            $table->integer('sort_order')->default(1);
            $table->integer('quantity')->default(0);
            $table->float('sale_price', 12, 2)->default(0);
            $table->float('discount_price', 12, 2)->default(0);
            $table->float('cost', 12, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('barcode')->nullable();
            $table->string('sku')->nullable();
            $table->longText('description')->nullable();
            $table->foreignUuid('category_id')->constrained()->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
