<?php

namespace Dorsone\Booking;

use Dorsone\Booking\Exceptions\InvalidEmailException;

class Notification
{

    /**
     * @throws InvalidEmailException
     */
    public static function send(string $email): void
    {
        $email = Validation::start($email)->email()->validate();

        $to = $email;
        $subject = "Booking.com";
        $message = "You successfully booked room!";

        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';

        mail($to, $subject, $message, implode(', ', $headers));
    }
}