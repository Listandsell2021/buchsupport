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
        Schema::create('admin_commissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('admins')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('incremental_no');
            $table->string('commission_no', 20);
            $table->date('commission_from');
            $table->date('commission_to');
            $table->date('commission_date');
            $table->float('total_gross');
            $table->float('subtotal');
            $table->float('tax');
            $table->float('tax_total');
            $table->unsignedBigInteger('previous_commission_id')->nullable();
            $table->foreign('previous_commission_id')->references('id')->on('admin_commissions')->cascadeOnUpdate()->nullOnDelete();
            $table->float('previous_unpaid');
            $table->float('total');
            $table->boolean('paid')->default(0);
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
        Schema::dropIfExists('admin_commissions');
    }
};
