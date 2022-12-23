<?php

namespace Dorsone\Booking;

use Dorsone\Booking\Exceptions\InvalidDateException;
use Dorsone\Booking\Exceptions\InvalidEmailException;
use Dorsone\Booking\Exceptions\InvalidIntegerException;
use Dorsone\Booking\Exceptions\NoRoomsException;

class Validation
{

    public function __construct(protected mixed $item){}

    public static function start($item): static
    {
        return new static($item);
    }

    /**
     * @throws InvalidDateException
     */
    public function date(): static
    {
        $test_arr  = explode('-', $this->item);

        if (count($test_arr) != 3) {
            throw new InvalidDateException('Invalid date format');
        }

        if (!checkdate($test_arr[1], $test_arr[2], $test_arr[0])) {
            throw new InvalidDateException('Invalid date format');
        }

        return $this;

    }

    /**
     * @throws InvalidIntegerException
     */
    public function integer(): static
    {
        if (!filter_var($this->item, FILTER_VALIDATE_INT)){
            throw new InvalidIntegerException('Invalid integer!');
        }
        $this->item = intval($this->item);
        return $this;
    }

    /**
     * @throws InvalidEmailException
     */
    public function email()
    {
        if (!filter_var($this->item, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException('Invalid email address!');
        }
        return $this;
    }

    /**
     * @throws InvalidDateException
     */
    public function dateRange($to): static
    {
        if (strtotime($this->item) > strtotime("+1 day")) {
            throw new InvalidDateException('Invalid Date Format');
        }

        if (strtotime($this->item) > strtotime($to)) {
            throw new InvalidDateException('Invalid Date Format');
        }
        return $this;
    }

    /**
     * @throws NoRoomsException
     */
    public function exists($primaryKeyName, $tableName): static
    {
        $db = DB::connect();

        $room = $db->table($tableName)->where($primaryKeyName, '=', $this->item)->get();

        if (empty($room)) {
            throw new NoRoomsException("Record with this $primaryKeyName [$this->item] not found");
        }

        return $this;
    }

    public function validate()
    {
        return $this->item;
    }
}