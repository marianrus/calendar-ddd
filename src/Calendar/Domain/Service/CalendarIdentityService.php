<?php

namespace App\Calendar\Domain\Service;

use App\Calendar\Domain\Repository\CalendarEventRepository;
use App\Calendar\Domain\Repository\CalendarRepository;

class CalendarIdentityService
{

    private $calendarRepository;

    private $calendarEventRepository;

    public function __construct(
        CalendarRepository $calendarRepository,
        CalendarEventRepository $calendarEventRepository
    ){
        $this->calendarRepository = $calendarRepository;
        $this->calendarEventRepository = $calendarEventRepository;
    }


    public function nextCalendarId()
    {
        return $this->calendarRepository->nextIdentity();
    }

    public function nextCalendarEventId()
    {
        return $this->calendarEventRepository->nextIdentity();
    }
}