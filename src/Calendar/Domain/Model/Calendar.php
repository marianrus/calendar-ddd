<?php

namespace App\Calendar\Domain\Model;


use App\Calendar\Domain\Service\CalendarIdentityService;
use Symfony\Component\VarDumper\VarDumper;
use Webmozart\Assert\Assert;

class Calendar
{
    /**
     * @var CalendarId
     */
    private $id;

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
    public static function createFrom(
        CalendarId $calendarId,
        string $name,
        string $description
    ) : Calendar
    {
        Assert::notNull($name, 'Name should not be empty');
        Assert::notNull($description, 'Description should not be empty');

        $aCalendar = new self();
        $aCalendar->id = $calendarId;

        $aCalendar->setName($name);
        $aCalendar->setDescription($description);

        return $aCalendar;
    }

    /**
     * @param CalendarIdentityService $calendarIdentityService
     * @param $description
     * @param $location
     * @param TimeSpan $span
     * @param $comment
     * @return CalendarEvent
     */
    public function scheduleCalendarEvent(
        CalendarIdentityService $calendarIdentityService,
        $description,
        $location,
        TimeSpan $span,
        $comment
    ){
        return CalendarEvent::create(
            $calendarIdentityService->nextCalendarEventId(),
            $this,
            $description,
            $location,
            $span,
            $comment
        );
    }

    /**
     * @return CalendarId
     */
    public function getId (): CalendarId
    {
        return $this->id;
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
        Assert::notNull($name, 'name should be provided');
        Assert::notEmpty($name, 'name should be provided');

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