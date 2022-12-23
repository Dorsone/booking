<?php

namespace Dorsone\Booking;

use DateTime;

class Booking
{
    protected false|DateTime $from;
    protected false|DateTime $to;
    protected DB $db;
    protected array $availableRooms;

    public function __construct(string $from, string $to)
    {
        $this->from = date_create($from);
        $this->to = date_create($to);
        $this->db = DB::connect();
    }

    public static function build(string $from, string $to): static
    {
        return new static($from, $to);
    }

    public function getAvailableRooms(): bool|array|null
    {
        $bookedRooms = $this->db->table('cabinets')
            ->innerJoin('booking', 'id', 'cabinet_id')
            ->where('from', '>=', $this->from->format('Y-m-d'))
            ->where('to', '<=', $this->to->format('Y-m-d'))
            ->get();

        $rooms = $this->db->table('cabinets')->get();

        if (is_null($bookedRooms)) {
            return $rooms;
        }

        foreach ($rooms as $key => $room) {
            foreach ($bookedRooms as $bookedKey => $bookedRoom) {
                if ($bookedRoom['cabinet_id'] == $room['id'])
                {
                    unset($rooms[$key]);
                    unset($bookedRooms[$bookedKey]);
                }
            }
        }

        return $this->availableRooms = $rooms;
    }

    public function bookRoom($roomId, $userEmail): string
    {
        return $this->db->table('booking')->insert([
            'cabinet_id' => $roomId,
            'user_email' => $userEmail,
            'from' => $this->from->format('Y-m-d'),
            'to' => $this->to->format('Y-m-d'),
        ]);
    }

}