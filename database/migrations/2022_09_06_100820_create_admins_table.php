<?php

use App\DataHolders\Enum\AuthRole;
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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('password');
            $table->string('email');
            $table->date('dob')->nullable();
            $table->string('phone_no')->nullable();
            $table->enum('gender', \App\DataHolders\Enum\Gender::onlyNames())->default(\App\DataHolders\Enum\Gender::male->name);
            $table->string('street')->nullable();
            $table->integer('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->enum('auth_role', AuthRole::onlyNames())->default(AuthRole::getAdminRole());
            $table->unsignedSmallInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('admin_roles')->cascadeOnUpdate()->nullOnDelete();
            $table->boolean('is_active')->default(0);
            $table->float('wallet')->default(0);
            $table->json('lead_columns')->nullable();
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
        Schema::dropIfExists('admins');
    }
};
