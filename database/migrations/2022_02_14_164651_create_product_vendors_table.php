<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_vendors', function (Blueprint $table) {
            $table->id();
            $table->integer('products_id');
            $table->string('url')->nullable();
            $table->string('shopProductId')->nullable();
            $table->float('price');
            $table->float('realPrice')->nullable();
            $table->string('sellerId')->nullable();
            $table->string('sellerName')->nullable();
            $table->string('sellerShopLink')->nullable();
            $table->boolean('isVendorActive')->default(true);

            $table->index('products_id');
            $table->index('price');
            $table->index('shopProductId');
            $table->index('sellerId');
            $table->index('sellerName');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_vendors');
    }
}
