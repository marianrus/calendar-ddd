<?php

namespace App\Calendar\Application;


use App\Calendar\Domain\Model\Calendar;
use App\Calendar\Domain\Model\CalendarEventId;
use App\Calendar\Domain\Model\CalendarId;
use App\Calendar\Domain\Model\TimeSpan;
use App\Calendar\Domain\Repository\CalendarEventRepository;
use App\Calendar\Domain\Repository\CalendarRepository;
use App\Calendar\Domain\Service\CalendarIdentityService;
use Broadway\Domain\DateTime;
use Symfony\Component\VarDumper\VarDumper;

class CalendarApplicationService
{
    /**
     * @var CalendarRepository
     */
    private $calendarRepository;

    private $calendarIdentityService;

    private $calendarEventRepository;

    /**
     * CalendarApplicationService constructor.
     * @param CalendarRepository $calendarRepository
     * @param CalendarIdentityService $calendarIdentityService
     * @param CalendarEventRepository $calendarEventRepository
     */
    public function __construct(
        CalendarRepository $calendarRepository,
        CalendarIdentityService $calendarIdentityService,
        CalendarEventRepository $calendarEventRepository
    ){
        $this->calendarRepository = $calendarRepository;
        $this->calendarIdentityService = $calendarIdentityService;
        $this->calendarEventRepository = $calendarEventRepository;
    }

    public function getAll()
    {
        return $this->calendarRepository->getAll();
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
     * @return Calendar
     */
    public function createCalendar($name, $description) : Calendar
    {
        $calendar = Calendar::create(
            $this->calendarRepository->nextIdentity(),
            $name,
            $description
        );
        $this->calendarRepository->save($calendar);

        return $calendar;
    }

    /**
     * @param CalendarId $calendarId
     * @param $description
     * @param $location
     * @param \DateTimeImmutable $timeSpanBegin
     * @param \DateTimeImmutable $timeSpanEnd
     * @param $comment
     * @return \App\Calendar\Domain\Model\CalendarEvent
     */
    public function scheduleCalendarEvent(
        CalendarId $calendarId,
        $description,
        $location,
        \DateTimeImmutable $timeSpanBegin,
        \DateTimeImmutable $timeSpanEnd,
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

        $this->calendarEventRepository->save($calendarEvent);
        return $calendarEvent;
    }
}