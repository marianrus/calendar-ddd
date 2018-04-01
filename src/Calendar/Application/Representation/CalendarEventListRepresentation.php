<?php

namespace App\Calendar\Application\Representation;


use App\Calendar\Domain\Model\CalendarEvent;
use App\Calendar\Domain\Model\TimeSpan;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\VarDumper\VarDumper;

class CalendarEventListRepresentation
{
    /**
     * @var array
     * @Serializer\SerializedName("calendar_events")
     */
    private $calendarEventList;

    /**
     * CalendarEventListRepresentation constructor.
     * @param array $calendarEvents
     */
    public function __construct (array $calendarEvents)
    {
        foreach($calendarEvents as $calendarEvent)
        {
            $this->calendarEventList[] = new CalendarEventRepresentation($calendarEvent);
        }
    }
}