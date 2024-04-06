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
        Schema::create('lead_contract', function (Blueprint $table) {
            $table->unsignedBigInteger('lead_id')->unique();
            $table->foreign('lead_id')->references('id')->on('leads')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('document')->nullable();
            $table->string('document_path')->nullable();
            $table->unsignedSmallInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->cascadeOnUpdate()->cascadeOnDelete();
            $table->smallInteger('quantity');
            $table->float('price');
            $table->string('note')->nullable();
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
        Schema::dropIfExists('lead_contract');
    }
};
