<?php

namespace App\Calendar\Domain\Model;

use Webmozart\Assert\Assert;

class CalendarEvent
{
    /**
     * @var CalendarEventId
     */
    private $id;

    /**
     * @var Calendar
     */
    private $calendar;

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
     * @param Calendar $calendar
     * @param string $description
     * @param string $location
     * @param TimeSpan $timeSpan
     * @param $comment
     * @return CalendarEvent
     */
    public static function create(
        CalendarEventId $eventId,
        Calendar $calendar,
        string $description,
        string $location,
        TimeSpan $timeSpan,
        $comment
    ) : CalendarEvent
    {
        $event = new self();
        $event->id = $eventId;
        $event->calendar = $calendar;

        $event->setDescription($description);
        $event->setLocation($location);
        $event->setComment($comment);
        $event->setTimeSpan($timeSpan);

        return $event;
    }

    /**
     * @param $description
     */
    private function setDescription($description)
    {
        Assert::notNull($description, 'Description should be provided');
        Assert::notEmpty($description, 'Description should not be empty');

        $this->description = $description;
    }

    /**
     * @param $timeSpan
     */
    private function setTimeSpan(TimeSpan $timeSpan)
    {
        Assert::notNull($timeSpan, 'Time Span should be provided');

        $this->timeSpan = $timeSpan;
    }

    /**
     * @param $comment
     */
    private function setComment($comment)
    {
        Assert::notNull($comment, 'Comment should be provided');
        Assert::notEmpty($comment, 'Comment should not be empty');

        $this->comment = $comment;
    }

    /**
     * @param $location
     */
    private function setLocation($location)
    {
        Assert::notNull($location, 'Location should be provided');
        Assert::notEmpty($location, 'Location should not be empty');

        $this->location = $location;
    }

    /**
     * @param $description
     * @param $location
     * @param TimeSpan $span
     * @param $comment
     * @return CalendarEvent
     */
    public function reSchedule(
        $description,
        $location,
        TimeSpan $span,
        $comment
    ){
        $this->setDescription($description);
        $this->setLocation($location);
        $this->setTimeSpan($span);
        $this->setComment($comment);

        return $this;
    }

    /**
     * @return CalendarEventId
     */
    public function getId (): CalendarEventId
    {
        return $this->id;
    }

    /**
     * @return CalendarId
     */
    public function getCalendarId (): CalendarId
    {
        return $this->calendar->getId();
    }

    /**
     * @return string
     */
    public function getDescription (): string
    {
        return $this->description;
    }

    /**
     * @return TimeSpan
     */
    public function getTimeSpan (): TimeSpan
    {
        return $this->timeSpan;
    }

    /**
     * @return string
     */
    public function getLocation (): string
    {
        return $this->location;
    }

    /**
     * @return string
     */
    public function getComment (): string
    {
        return $this->comment;
    }

}
