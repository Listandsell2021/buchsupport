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
    public function up(): void
    {
        Schema::create('service_pipelines', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->unsignedSmallInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name');
            $table->boolean('has_tracking')->default(0);
            $table->boolean('default')->default(0);
            $table->smallInteger('order_no')->default(1);
            $table->unique(['service_id', 'name']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('service_pipelines');
    }
};
