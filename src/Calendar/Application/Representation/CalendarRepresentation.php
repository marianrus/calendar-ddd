<?php

namespace App\Calendar\Application\Representation;


use App\Calendar\Domain\Model\Calendar;

class CalendarRepresentation
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * CalendarRepresentation constructor.
     * @param Calendar $calendar
     */
    public function __construct (Calendar $calendar)
    {
        $this->id = $calendar->getCalendarId()->toString();
        $this->name = $calendar->getName();
        $this->description = $calendar->getDescription();
    }
}