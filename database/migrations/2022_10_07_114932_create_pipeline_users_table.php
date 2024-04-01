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
        Schema::create('pipeline_users', function (Blueprint $table) {

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->unsignedSmallInteger('pipeline_id')->nullable();
            $table->foreign('pipeline_id')
                ->references('id')
                ->on('pipelines')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->smallInteger('order_no')->default(0);

            $table->unique(['user_id', 'pipeline_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('pipeline_users');
    }
};
