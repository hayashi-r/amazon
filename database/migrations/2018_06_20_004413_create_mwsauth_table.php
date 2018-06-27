<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMwsauthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mwsauth', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('custId');
            $table->string('seller_id')->unique();
            $table->string('token');
            $table->string('marketplace_name');
            $table->string('custom_name');
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
        Schema::dropIfExists('mwsauth');
    }
}
