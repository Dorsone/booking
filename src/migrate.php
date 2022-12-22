<?php

use Dorsone\Booking\Config;

require_once('./vendor/autoload.php');

try {
    $sql = file_get_contents('src/booking.sql');
    $mysqli = new mysqli(Config::DB_HOSTNAME->value, Config::DB_USERNAME->value, Config::DB_PASSWORD->value, Config::DB_NAME->value);
    $mysqli->multi_query($sql);
    echo "Migrated successfully!";
}catch (Exception $exception){
    echo $exception->getMessage();
}