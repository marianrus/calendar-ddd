<?php

namespace App\Calendar\Domain\Repository;

use App\Calendar\Domain\Model\CalendarEvent;
use App\Calendar\Domain\Model\CalendarEventId;

interface CalendarEventRepository
{
    public function getById(CalendarEventId $calendarEventId) : CalendarEvent;

    public function nextIdentity() : CalendarEventId;

    public function save(CalendarEvent $calendarEvent) : void;

    public function remove(CalendarEvent $calendarEvent) : void;
}