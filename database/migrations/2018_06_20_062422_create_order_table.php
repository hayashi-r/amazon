<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('custId');
            $table->string('orderid');
            $table->string('purchasedate');
            $table->string('shipby');
            $table->string('buyeremail');
            $table->string('buyername');
            $table->string('buyerphone');
            $table->string('sku');
            $table->string('productname');
            $table->integer('qtypurchased');
            $table->string('shiplevel');
            $table->string('recipient');
            $table->string('address1');
            $table->string('address2');
            $table->string('address3');
            $table->string('city');
            $table->string('state');
            $table->string('postalcode');
            $table->string('country');
            $table->boolean('businessorder');
            $table->string('marketplace');
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
        Schema::dropIfExists('order');
    }
}
