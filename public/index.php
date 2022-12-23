<?php

use Dorsone\Booking\Exceptions\NoRoomsException;
use Dorsone\Booking\Program;

require_once('../vendor/autoload.php');

try {
    Program::start()->index();
} catch (NoRoomsException $exception) {
    Program::start()->index();
}