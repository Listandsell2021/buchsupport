<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uid', 20)->unique()->index();
            $table->enum('membership', \App\DataHolders\Enum\Membership::onlyNames())->nullable(); //->default(\App\DataHolders\Enum\Membership::bronze->name)
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->enum('gender', \App\DataHolders\Enum\Gender::onlyNames())->default(\App\DataHolders\Enum\Gender::male->name);
            $table->string('phone_no')->nullable();
            $table->string('street')->nullable();
            $table->integer('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('password');
            $table->string('password_text', 30)->nullable();
            $table->date('dob')->nullable();
            $table->string('note')->nullable();
            $table->string('image_path')->nullable();
            $table->boolean('is_special')->default(0);
            $table->string('secondary_first_name')->nullable();
            $table->string('secondary_last_name')->nullable();
            $table->boolean('is_active')->default(0);
            $table->boolean('auto_invoice')->default(0);
            $table->tinyInteger('auto_invoice_date')->default(1);
            $table->dateTime('registered_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

//`membership_id``is_admin``first_name``last_name``gender``address``zip``city``country``password``password_text``birth``has_gender``note``image_path``second_owner_first_name``second_owner_last_name``is_special``api_token`


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
