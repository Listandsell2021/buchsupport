<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailTemplatesTable extends Migration
{
    public function up()
    {
        Schema::create('mail_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('mailable');
            $table->text('subject')->nullable();
            $table->longtext('html_template');
            $table->longtext('text_template')->nullable();
            $table->string('layout_path')->nullable();
            $table->longtext('html_layout')->nullable();
            $table->string('style_path')->nullable();
            $table->longtext('html_style')->nullable();
            $table->timestamps();
        });
    }
}
