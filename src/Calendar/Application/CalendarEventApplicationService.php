<?php

namespace App\Calendar\Application;


use App\Calendar\Application\Exception\CalendarEventNotFoundException;
use App\Calendar\Domain\Model\CalendarEventId;
use App\Calendar\Domain\Model\CalendarId;
use App\Calendar\Domain\Model\TimeSpan;
use App\Calendar\Domain\Repository\CalendarEventRepository;
use App\Calendar\Domain\Service\CalendarIdentityService;

class CalendarEventApplicationService
{
    /**
     * @var CalendarEventRepository
     */
    private $calendarEventRepository;

    /**
     * @var CalendarApplicationService
     */
    private $calendarApplicationService;

    /**
     * @var CalendarIdentityService
     */
    private $calendarIdentityService;

    /**
     * CalendarEventApplicationService constructor.
     * @param CalendarEventRepository $calendarEventRepository
     * @param CalendarApplicationService $calendarApplicationService
     * @param CalendarIdentityService $calendarIdentityService
     */
    public function __construct (
        CalendarEventRepository $calendarEventRepository,
        CalendarApplicationService $calendarApplicationService,
        CalendarIdentityService $calendarIdentityService
    ){
        $this->calendarEventRepository = $calendarEventRepository;
        $this->calendarIdentityService = $calendarIdentityService;
    }

    /**
     * @param $calendarEventId
     * @throws CalendarEventNotFoundException
     */
    public function getCalendarEventById(CalendarEventId $calendarEventId)
    {
        $calendarEvent = $this->calendarEventRepository->getById($calendarEventId);

        if(!$calendarEvent) {
            throw new CalendarEventNotFoundException();
        }

        return $calendarEvent;
    }

    /**
     * @param CalendarEventId $calendarEventId
     * @param $description
     * @param $location
     * @param \DateTimeImmutable $timeSpanBegin
     * @param \DateTimeImmutable $timeSpanEnd
     * @param $comment
     * @return \App\Calendar\Domain\Model\CalendarEvent
     * @throws CalendarEventNotFoundException
     */
    public function reScheduleCalendarEvent(
        CalendarEventId $calendarEventId,
        $description,
        $location,
        \DateTimeImmutable $timeSpanBegin,
        \DateTimeImmutable $timeSpanEnd,
        $comment
    ){
        $calendarEvent = $this->getCalendarEventById($calendarEventId);

        if(!$calendarEvent) {
            throw new CalendarEventNotFoundException();
        }

        $calendarEvent = $calendarEvent->reSchedule(
            $description,
            $location,
            new TimeSpan($timeSpanBegin, $timeSpanEnd),
            $comment
        );

        $this->calendarEventRepository->save($calendarEvent);

        return $calendarEvent;
    }


    /**
     * @param $calendarEventId
     * @throws CalendarEventNotFoundException
     */
    public function cancelByCalendarEvent($calendarEventId)
    {
        $calendarEvent = $this->getCalendarEventById($calendarEventId);

        $this->calendarEventRepository->remove($calendarEvent);
    }
}
