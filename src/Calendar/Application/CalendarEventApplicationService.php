<?php

namespace App\Calendar\Application;


use App\Calendar\Domain\Repository\CalendarEventRepository;

class CalendarEventApplicationService
{
    /**
     * @var CalendarEventRepository
     */
    private $calendarEntryRepository;

    /**
     * CalendarEventApplicationService constructor.
     * @param CalendarEventRepository $calendarEventRepository
     */
    public function __construct (CalendarEventRepository $calendarEventRepository)
    {
        $this->calendarEntryRepository = $calendarEventRepository;
    }

    public function createCalendarEvent()
    {

    }
}