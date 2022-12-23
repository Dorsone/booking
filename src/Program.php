<?php

namespace Dorsone\Booking;

use Dorsone\Booking\Exceptions\InvalidEmailException;
use Dorsone\Booking\Exceptions\NoRoomsException;

class Program
{
    private mixed $from;
    private mixed $to;
    private mixed $roomId;
    private mixed $userEmail;

    public static function start(): static
    {
        return new static();
    }

    /**
     * @throws NoRoomsException
     * @throws InvalidEmailException
     */
    public function index(): void
    {
        $this->getDates();
        $booking = Booking::build($this->from, $this->to);
        $rooms = $booking->getAvailableRooms();

        if (empty($rooms)) {
            throw new NoRoomsException('There are no available rooms!');
        }

        $result = 'AVAILABLE ROOMS: ' . PHP_EOL;
        foreach ($rooms as $room) {
            $result .= sprintf("ID: %d | NAME: %s\n", $room['id'], $room['name']);
        }
        echo $result;

        $this->getBookingInformation();

        if (!$booking->bookRoom($this->roomId, $this->userEmail)) {
            echo 'Something went wrong';
        }
        Notification::send($this->userEmail);
        echo 'Room booked successfully!';
    }

    protected function getBookingInformation(): void
    {
        $this->roomId = Console::make(PHP_EOL."Choose one of the rooms and write it's ID: ")->input();
        $this->userEmail = Console::make("Write your email: ")->input();
        $this->validateBookInformation();
    }

    protected function validateBookInformation(): void
    {
        try {
            $this->roomId = Validation::start($this->roomId)->integer()->validate();
            $this->userEmail = Validation::start($this->userEmail)->email()->validate();
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            die();
        }
    }

    protected function getDates(): void
    {
        $this->from = Console::make("Write booking date from (ex: 2022-12-15): ")->input();
        $this->to = Console::make("Write booking date from (ex: 2022-12-21): ")->input();
        $this->validateDateRange();
    }

    protected function validateDateRange(): void
    {
        try {
            $this->from = Validation::start($this->from)->date()->validate();
            $this->to = Validation::start($this->to)->date()->validate();
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            die();
        }
    }

}