<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('order_id')->constrained()->onDelete('cascade');
            // $table->foreignUuid('product_id')->constrained()->onDelete('cascade');
            $table->string('product_name');
            $table->longText('product_image_url');

            $table->integer('quantity');
            $table->float('price', 12, 2);
            $table->float('cost', 12, 2);
            $table->float('total', 12, 2);
            $table->float('total_cost', 12, 2);

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
        Schema::dropIfExists('order_details');
    }
}
