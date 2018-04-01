<?php

namespace App\Calendar\Application\Representation;


use App\Calendar\Domain\Model\CalendarEvent;
use App\Calendar\Domain\Model\TimeSpan;

class CalendarEventRepresentation
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $calendarId;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \DateTimeImmutable
     */
    private $begins;

    /**
     * @var \DateTimeImmutable
     */
    private $ends;

    /**
     * @var string
     */
    private $location;

    /**
     * @var string
     */
    private $comment;

    public function __construct (CalendarEvent $calendarEvent)
    {
        $this->id = $calendarEvent->getId()->toString();
        $this->calendarId = $calendarEvent->getCalendarId()->toString();
        $this->description = $calendarEvent->getDescription();
        $this->comment = $calendarEvent->getComment();
        $this->location = $calendarEvent->getLocation();
        $this->begins = $calendarEvent->getTimeSpan()->getBegins()->format(TimeSpan::FORMAT_STRING);
        $this->ends = $calendarEvent->getTimeSpan()->getEnds()->format(TimeSpan::FORMAT_STRING);
    }
}