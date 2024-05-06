<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWasteItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waste_items', function (Blueprint $table) {
            $table->id();
            $table->string('master_item_id');
            $table->string('master_item_name');
            $table->string('unit');
            $table->float('quantity', 12, 2)->default(0);
            $table->float('loss', 12, 2)->default(0);
            $table->longText('notes')->nullable();
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
        Schema::dropIfExists('waste_items');
    }
}
