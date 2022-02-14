<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('products_id')->nullable();
            $table->integer('product_vendors_id')->nullable();
            $table->float('price');
            $table->float('realPrice')->nullable();
            $table->date('trackedDate');

            $table->index('products_id');
            $table->index('product_vendors_id');
            $table->index('trackedDate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('price_histories');
    }
}
