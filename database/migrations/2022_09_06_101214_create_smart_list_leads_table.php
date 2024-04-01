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
        Schema::create('smart_list_leads', function (Blueprint $table) {
            $table->foreignId('smart_list_id')->constrained('smart_lists')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('lead_id')->constrained('leads')->cascadeOnUpdate()->cascadeOnDelete();
            $table->smallInteger('order_no')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('smart_list_leads');
    }
};
