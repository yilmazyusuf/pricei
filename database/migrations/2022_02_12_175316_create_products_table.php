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
            $table->id();
            $table->integer('user_id');
            $table->integer('platform_id')->nullable();
            $table->string('name');
            $table->string('url');
            $table->string('productId');
            $table->string('imageUrl');
            $table->float('price');
            $table->float('realPrice')->nullable();
            $table->float('sellingPrice')->nullable();
            $table->string('currency');
            $table->string('sellerId')->nullable();
            $table->string('sellerName')->nullable();
            $table->string('sellerShopLink')->nullable();

            //job
            $table->boolean('isJobLocked')->default(false);
            $table->boolean('isJobActive')->default(false);
            $table->tinyInteger('jobTries')->default(0);
            $table->boolean('lasJobStatus')->nullable();

            $table->dateTime('lastJobDate')->nullable();
            $table->dateTime('nextJobDate')->nullable();


            $table->timestamps();
            $table->softDeletes();

            $table->index('platform_id');
            $table->index('productId');
            $table->index('price');
            $table->index('name');
            $table->index('sellerId');
            $table->index('sellerName');

            $table->unique(['user_id', 'platform_id', 'productId']);
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
