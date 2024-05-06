<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('customer_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            
            $table->string('number')->unique();

            $table->float('delivery_charge', 12, 2);
            $table->integer('tax_rate');
            $table->float('subtotal', 12, 2);
            $table->float('discount', 12, 2);
            $table->float('total', 12, 2);
            $table->float('tender_amount', 12, 2);
            $table->float('change', 12, 2);

            $table->longText('remarks')->nullable();

            $table->string('table_name')->nullable();
            $table->string('table_status')->nullable();

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
        Schema::dropIfExists('orders');
    }
}
