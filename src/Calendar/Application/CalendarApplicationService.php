<?php

namespace App\Calendar\Application;


use App\Calendar\Application\Exception\CalendarNotFoundException;
use App\Calendar\Domain\Model\Calendar;
use App\Calendar\Domain\Model\CalendarId;
use App\Calendar\Domain\Model\TimeSpan;
use App\Calendar\Domain\Repository\CalendarEventRepository;
use App\Calendar\Domain\Repository\CalendarRepository;
use App\Calendar\Domain\Service\CalendarIdentityService;

class CalendarApplicationService
{
    /**
     * @var CalendarRepository
     */
    private $calendarRepository;

    /**
     * @var CalendarIdentityService
     */
    private $calendarIdentityService;

    /**
     * @var CalendarEventRepository
     */
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

    /**
     * @return mixed
     */
    public function getCalendars()
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
     * @return Calendar
     * @throws CalendarNotFoundException
     */
    public function getCalendarById($calendarId)
    {
        if($calendar = $this->calendarRepository->getById($calendarId)) {
            return $calendar;
        }

        throw new CalendarNotFoundException();
    }

    /**
     * @param $calendarId
     * @param $rename
     * @throws CalendarNotFoundException
     */
    public function renameCalendar($calendarId, $rename)
    {
        $calendar = $this->getCalendarById($calendarId);
        $calendar->setName($rename);
    }

    /**
     * @param $name
     * @param $description
     * @return Calendar
     */
    public function createCalendar($name, $description) : Calendar
    {
        $calendar = Calendar::createFrom(
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
     * @throws CalendarNotFoundException
     */
    public function scheduleCalendarEvent(
        CalendarId $calendarId,
        $description,
        $location,
        \DateTimeImmutable $timeSpanBegin,
        \DateTimeImmutable $timeSpanEnd,
        $comment
    ){
        $calendar = $this->getCalendarById($calendarId);

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