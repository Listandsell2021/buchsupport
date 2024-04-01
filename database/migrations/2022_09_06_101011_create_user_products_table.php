<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_products', function (Blueprint $table) {
            $table->id();
            $table->string('form_id', 36);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('note', 1255)->nullable();
            $table->decimal('price', 10, 2);
            $table->smallInteger('quantity')->default(1);
            $table->tinyInteger('condition');
            $table->integer('position')->default(0);
            $table->integer('form_order_no')->default(0);
            $table->boolean('is_hidden')->default(false);
            $table->boolean('show_price')->default(false);
            $table->boolean('show_purchase_date')->default(false);
            $table->date('purchased_date');
            $table->boolean('status');
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
        Schema::dropIfExists('user_products');
    }
};
