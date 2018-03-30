<?php

namespace App\Calendar\Application;


use App\Calendar\Domain\Model\Calendar;
use App\Calendar\Domain\Model\CalendarId;
use App\Calendar\Domain\Model\TimeSpan;
use App\Calendar\Domain\Repository\CalendarRepository;
use App\Calendar\Domain\Service\CalendarIdentityService;

class CalendarApplicationService
{
    /**
     * @var CalendarRepository
     */
    private $calendarRepository;

    private $calendarIdentityService;

    /**
     * CalendarApplicationService constructor.
     * @param CalendarRepository $calendarRepository
     * @param CalendarIdentityService $calendarIdentityService
     */
    public function __construct(
        CalendarRepository $calendarRepository,
        CalendarIdentityService $calendarIdentityService
    ){
        $this->calendarRepository = $calendarRepository;
        $this->calendarIdentityService = $calendarIdentityService;
    }

    /**
     * @param $calendarId
     * @param $calendarDescription
     */
    public function changeCalendarDescription($calendarId, $calendarDescription)
    {
        $calendar = $this->calendarRepository->getById($calendarId);
        $calendar->setDescription($calendarDescription);
    }

    /**
     * @param $calendarId
     * @param $rename
     */
    public function renameCalendar($calendarId, $rename)
    {
        $calendar = $this->calendarRepository->getById($calendarId);
        $calendar->setName($rename);
    }

    /**
     * @param $name
     * @param $description
     */
    public function createCalendar($name, $description)
    {
        $calendar = Calendar::create(
            $this->calendarRepository->nextIdentity(),
            $name,
            $description
        );

        $this->calendarRepository->save($calendar);
    }

    /**
     * @param $calendarId
     */
    public function scheduleCalendarEvent(
        CalendarId $calendarId,
        $description,
        $location,
        \DateTime $timeSpanBegin,
        \DateTimeInterface $timeSpanEnd,
        $comment
    ){
        $calendar = $this->calendarRepository->getById($calendarId);

        $calendarEvent = $calendar->scheduleCalendarEvent(
            $this->calendarIdentityService,
            $description,
            $location,
            new TimeSpan($timeSpanBegin, $timeSpanEnd),
            $comment
        );
    }
}