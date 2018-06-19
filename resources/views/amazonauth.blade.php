<?php

namespace App\Http\Controllers;

use App\Mwsauth;
use Illuminate\Http\Request;
use App\Http\Controllers\SettingsController;

class

$mws = new Mwsauth;

$mws->seller_id = $request->seller_id;
$mws->token =  $request->token;
$mws->marketplace_id = $request->marketplace_id;
$mws->marketplace_name = $request->marketplace_name;
$mws->custom_name = $request->custom_name;

$mws->save();

/*
if (!Schema::hasTable('mwsauth')) {

  Schema::connection('mysql')->create('mwsauth', function($table)
   {
      $table->increments('id');
      $table->string('seller_id')->unique();
      $table->string('token');
      $table->string('marketplace_id');
      $table->string('marketplace_name');
      $table->string('custom_name');
      $table->timestamps();
  });

};
*/
