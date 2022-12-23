<?php

namespace Dorsone\Booking;

use Exception;
use mysqli;

class Migration
{
    public static function start(): void
    {
        try {
            $sql = file_get_contents(__DIR__.'/booking.sql');
            $mysqli = new mysqli(Config::DB_HOSTNAME->value, Config::DB_USERNAME->value, Config::DB_PASSWORD->value, Config::DB_NAME->value);
            $mysqli->multi_query($sql);
            echo "Migrated successfully!";
        }catch (Exception $exception){
            echo $exception->getMessage();
        }
    }
}