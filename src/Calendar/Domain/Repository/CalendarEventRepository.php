<?php

namespace App\Calendar\Domain\Repository;

use App\Calendar\Domain\Model\CalendarEvent;
use App\Calendar\Domain\Model\CalendarEventId;
use App\Calendar\Domain\Model\CalendarId;

interface CalendarEventRepository
{
    public function getById(CalendarEventId $calendarEventId) : CalendarEvent;

    public function getByCalendarId(CalendarId $calendarId);

    public function nextIdentity() : CalendarEventId;

    public function save(CalendarEvent $calendarEvent) : void;

    public function remove(CalendarEvent $calendarEvent) : void;
}