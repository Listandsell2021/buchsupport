<?php

use App\DataHolders\Enum\OrderStatus;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('admin_id')->nullable();
            $table->foreign('admin_id')
                ->references('id')
                ->on('admins')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->unsignedBigInteger('lead_id')->nullable();
            $table->foreign('lead_id')
                ->references('id')
                ->on('leads')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->unsignedSmallInteger('service_id');
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->unsignedSmallInteger('pipeline_id');

            $table->float('price');
            $table->integer('quantity');
            $table->float('subtotal');
            $table->float('tax');
            $table->float('tax_price');
            $table->float('total');
            $table->string('shipment_no')->nullable();
            $table->string('document')->nullable();
            $table->string('document_path')->nullable();
            $table->text('note')->nullable();
            $table->boolean('commissioned')->default(0);
            $table->enum('status', OrderStatus::onlyNames())->nullable();
            $table->smallInteger('order_no')->default(1);
            $table->dateTime('order_at');
        });

        \Illuminate\Support\Facades\DB::statement("ALTER TABLE orders AUTO_INCREMENT = 10000;");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
