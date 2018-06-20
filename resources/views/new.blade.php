<?php

Schema::connection('mysql')->create('amazon', function($table)
 {
    $table->increments('id');
    $table->timestamps();
});

?>
