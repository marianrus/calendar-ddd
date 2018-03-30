<?php

namespace App\Calendar\Domain\Model;


use App\Calendar\Domain\Service\CalendarIdentityService;
use Webmozart\Assert\Assert;

class Calendar
{
    /**
     * @var CalendarId
     */
    private $calendarId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var
     */
    private $description;

    /**
     * @param CalendarId $calendarId
     * @param string $name
     * @param string $description
     * @return Calendar
     */
    public static function create(CalendarId $calendarId, string $name, string $description) : Calendar
    {
        Assert::notNull($name, 'Name should not be empty');
        Assert::notNull($description, 'Description should not be empty');

        $aCalendar = new self();
        $aCalendar->calendarId = $calendarId;

        $aCalendar->setName($name);
        $aCalendar->setDescription($description);

        return $aCalendar;
    }

    public function scheduleCalendarEvent(
        CalendarIdentityService $calendarIdentityService,
        $description,
        $location,
        TimeSpan $span,
        $comment
    ){
        return CalendarEvent::create(
            $calendarIdentityService->nextCalendarEventId(),
            $this->getCalendarId(),
            $description,
            $location,
            $span,
            $comment
        );
    }

    /**
     * @return CalendarId
     */
    public function getCalendarId (): CalendarId
    {
        return $this->calendarId;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription() : string
    {
        return $this->description;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        Assert::notNull($name, 'rename should be provided');
        Assert::notEmpty($name, 'rename should be provided');

        $this->name = $name;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        Assert::notNull($description, 'description should be provided');
        Assert::notEmpty($description, 'description should be provided');

        $this->description = $description;
    }
}