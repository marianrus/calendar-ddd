<?php

namespace App\Calendar\Domain\Repository;

use App\Calendar\Domain\Model\Calendar;
use App\Calendar\Domain\Model\CalendarEventId;
use App\Calendar\Domain\Model\CalendarId;
use Doctrine\Common\Collections\ArrayCollection;

interface CalendarRepository
{
    public function getById(CalendarId $calendarId) : Calendar;

    public function nextIdentity() : CalendarId;

    public function save(Calendar $calendar) : void;

    public function getAll();
}