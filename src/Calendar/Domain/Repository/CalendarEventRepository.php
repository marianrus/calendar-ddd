<?php

namespace App\Calendar\Domain\Repository;


use App\Calendar\Domain\Model\Calendar;
use App\Calendar\Domain\Model\CalendarEventId;
use App\Calendar\Domain\Model\CalendarId;
use Ramsey\Uuid\Uuid;

class CalendarEventRepository
{
    public function getById(CalendarId $calendarId) : Calendar
    {

    }

    public function nextIdentity()
    {
        return new CalendarEventId(Uuid::uuid4()->toString());
    }

    public function save(Calendar $calendar)
    {

    }
}