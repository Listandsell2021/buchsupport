<?php

use App\DataHolders\Enum\Gender;
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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();

            $table->string('year', 4);
            $table->smallInteger('incremental_no');
            $table->date('invoice_date');
            $table->string('invoice_no')->unique();

            $table->string('user_company')->nullable();
            $table->enum('user_gender', Gender::onlyNames())->default(Gender::male->value);
            $table->string('user_name');
            $table->text('user_address');
            $table->string('user_no');

            $table->text('services');
            $table->float('service_total');
            $table->float('subtotal');
            $table->float('vat');
            $table->float('vat_total');
            $table->float('total');

            $table->boolean('is_paid')->default(0);
            $table->string('invoice_path')->nullable();

            $table->boolean('is_cancelled')->default(0);
            $table->integer('cancelled_inc_no')->nullable();
            $table->string('cancelled_invoice_no')->nullable();
            $table->string('cancelled_invoice_path')->nullable();
            $table->dateTime('cancelled_invoice_sent_at')->nullable();

            $table->boolean('payment_reminder')->default(0);
            $table->date('payment_reminder_on')->nullable();
            $table->string('payment_reminder_path')->nullable();
            $table->dateTime('payment_reminder_sent_at')->nullable();

            $table->boolean('payment_warning')->default(0);
            $table->date('payment_warning_on')->nullable();
            $table->string('payment_warning_path')->nullable();
            $table->dateTime('payment_warning_sent_at')->nullable();

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
        Schema::dropIfExists('invoices');
    }
};
