<?php

namespace App\Calendar\Application\Exception;


use Throwable;

class CalendarNotFoundException extends \Exception
{
    public function __construct (string $message = "calendar_not_found", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}