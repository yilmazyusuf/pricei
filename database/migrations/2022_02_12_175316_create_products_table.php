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

            //Queue
            $table->boolean('isQueueDisabled')->default(false)->nullable();
            $table->tinyInteger('queueDisabledReason')->nullable();
            $table->tinyInteger('queueStatus')->default(0)->nullable()->comment('(0 kullanıcı aksiyonu bekleniyor, 1 görev yok, 2 kuyrukta, 3 çalışıyor)');
            $table->boolean('hasQueueError')->default(false)->nullable();
            $table->integer('totalQueueCount')->default(0)->nullable();
            $table->integer('queueErrorCount')->default(0)->nullable();
            $table->string('lastQueueErrorMsg')->nullable();
            $table->dateTime('lastQueueErrorDate')->nullable();
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
