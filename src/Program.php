<?php

namespace Dorsone\Booking;

class Program
{
    public static function start(): void
    {
        echo "Write booking date from (ex: 2022-12-15): ";
        $from = readline();
        echo "Write booking date from (ex: 2022-12-21): ";
        $to = readline();

        $booking = Booking::build($from, $to);

        $rooms = $booking->getAvailableRooms();

        if (empty($rooms)) {
            print_r('There are no available rooms!' . PHP_EOL . PHP_EOL);
            static::start();
        }

        $result = 'AVAILABLE ROOMS: ' . PHP_EOL;
        foreach ($rooms as $room) {
            $result .= "ID: " . $room['id'] . ' | ' . "NAME: " . $room['name'] . PHP_EOL;
        }
        print_r($result . PHP_EOL."Choose one of the rooms and write it's ID: ");
        $roomId = intval(readline());
        print_r('Write your email: ');
        $userEmail = readline();
        print_r($booking->bookRoom($roomId, $userEmail));
    }
}