<?php

namespace Dorsone\Booking;

class Console
{
    public function __construct(protected string $message = '')
    {
    }

    public static function make($message = ''): static
    {
        return new static($message);
    }

    public function input(): bool|string
    {
        echo trim($this->message) . " ";
        return readline();
    }
}