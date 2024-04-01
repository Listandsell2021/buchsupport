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
        Schema::create('lead_contract_products', function (Blueprint $table) {
            $table->id();
            $table->unique(['contract_id', 'product_id']);
            $table->unsignedBigInteger('contract_id');
            $table->foreign('contract_id')->references('id')->on('lead_contracts')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnUpdate()->cascadeOnDelete();
            $table->smallInteger('quantity');
            $table->float('price');
            $table->tinyInteger('condition')->default(1);
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
        Schema::dropIfExists('lead_contract_products');
    }
};
