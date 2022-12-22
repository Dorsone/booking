<?php

namespace Dorsone\Booking;

enum Config: string
{
    case DB_HOSTNAME = 'localhost';
    case DB_USERNAME = 'root';
    case DB_PASSWORD = 'mypass';
    case DB_NAME = 'booking';
}