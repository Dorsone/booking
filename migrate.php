<?php

require_once('Config.php');

try {
    $sql = file_get_contents('booking.sql');
    $mysqli = new mysqli(Config::DB_HOSTNAME->value, Config::DB_USERNAME->value, Config::DB_PASSWORD->value, Config::DB_NAME->value);
    $mysqli->multi_query($sql);
    echo "Migrated successfully!";
}catch (Exception $exception){
    echo $exception->getMessage();
}