<?php

namespace App\Calendar\Application\Exception;


use Throwable;

class CalendarEventNotFoundException extends \Exception
{
    public function __construct (string $message = "calendar_event_not_found", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}