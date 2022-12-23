<?php

namespace Dorsone\Booking;

use Dorsone\Booking\Exceptions\InvalidDateException;
use Dorsone\Booking\Exceptions\InvalidEmailException;
use Dorsone\Booking\Exceptions\InvalidIntegerException;

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

    public function validate()
    {
        return $this->item;
    }
}