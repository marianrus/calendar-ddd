<?php

namespace App\Calendar\Domain\Repository;


use App\Calendar\Domain\Model\Calendar;
use App\Calendar\Domain\Model\CalendarEvent;
use App\Calendar\Domain\Model\CalendarEventId;
use App\Calendar\Domain\Model\CalendarId;
use Ramsey\Uuid\Uuid;

class CalendarRepository
{
    public function getById(CalendarId $calendarId) : Calendar
    {

    }

    public function nextIdentity()
    {
        return new CalendarId(Uuid::uuid4()->toString());
    }

    public function save(Calendar $calendar)
    {

    }
}