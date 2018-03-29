<?php

namespace App\Calendar\Domain\Model;

use Webmozart\Assert\Assert;

class Event
{
    /**
     * @var EventId
     */
    private $eventId;

    /**
     * @var CalendarId
     */
    private $calendarId;

    /**
     * @var string
     */
    private $description;

    /**
     * @var static
     */
    private $timeSpan;

    /**
     * @var string
     */
    private $location;

    /**
     * @var string
     */
    private $comment;

    /**
     * @param EventId $eventId
     * @param CalendarId $calendarId
     * @param string $description
     * @param string $location
     * @param TimeSpan $timeSpan
     * @param $comment
     * @return Event
     */
    public function create(
        EventId $eventId,
        CalendarId $calendarId,
        string $description,
        string $location,
        TimeSpan $timeSpan,
        $comment
    ) : Event
    {
        Assert::notEmpty($description);
        Assert::maxLength(100, 'Description length must not exceed 100');

        $this->eventId = $eventId;
        $this->calendarId = $calendarId;
        $this->description = $description;
        $this->timeSpan = $timeSpan;
        $this->location = $location;
        $this->comment = $comment;
    }



}
