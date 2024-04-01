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
        Schema::create('products', function (Blueprint $table) {
            $table->integerIncrements('id');

            $table->unsignedSmallInteger('category_id')->nullable();
            $table->foreign('category_id')
                ->references('id')
                ->on('product_categories')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->string('youtube_link', 200)->nullable();
            $table->boolean('is_archived')->default(0);
            $table->boolean('is_active')->default(1);
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
};
