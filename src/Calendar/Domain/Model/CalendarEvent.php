<?php

namespace App\Calendar\Domain\Model;

use Webmozart\Assert\Assert;

class CalendarEvent
{
    /**
     * @var CalendarEventId
     */
    private $calendarEventId;

    /**
     * @var CalendarId
     */
    private $calendarId;

    /**
     * @var string
     */
    private $description;

    /**
     * @var TimeSpan
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
     * @param CalendarEventId $eventId
     * @param CalendarId $calendarId
     * @param string $description
     * @param string $location
     * @param TimeSpan $timeSpan
     * @param $comment
     * @return CalendarEvent
     */
    public static function create(
        CalendarEventId $eventId,
        CalendarId $calendarId,
        string $description,
        string $location,
        TimeSpan $timeSpan,
        $comment
    ) : CalendarEvent
    {
        Assert::notEmpty($description);
        Assert::maxLength(100, 'Description length must not exceed 100');
        
        $event = new self();
        $event->calendarEventId = $eventId;
        $event->calendarId = $calendarId;
        $event->description = $description;
        $event->timeSpan = $timeSpan;
        $event->location = $location;
        $event->comment = $comment;

        return $event;
    }



}
