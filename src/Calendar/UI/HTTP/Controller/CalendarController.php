<?php

namespace App\Calendar\UI\HTTP\Controller;


use App\Calendar\Application\CalendarApplicationService;
use App\Calendar\Application\Representation\CalendarRepresentation;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CalendarController
 * @package App\Calendar\UI\HTTP\Controller
 * @Route(
 *     path="/calendar"
 * )
 */
class CalendarController
{
    /**
     * @var CalendarApplicationService
     */
    private $appCalendarService;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * CalendarController constructor.
     * @param CalendarApplicationService $applicationService
     * @param SerializerInterface $serializer
     */
    public function __construct (
        CalendarApplicationService $applicationService,
        SerializerInterface $serializer
    )
    {
        $this->appCalendarService = $applicationService;
        $this->serializer = $serializer;
    }

    /**
     * @Route(
     *     methods={"GET"}
     * )
     *
     * @return JsonResponse
     */
    public function getCalendars()
    {
        return new JsonResponse($this->appCalendarService->getCalendars());
    }

    /**
     * @Route(
     *     methods={"GET"},
     *     path="/calendar/{calendarId}"
     * )
     *
     * @return JsonResponse
     */
    public function getCalendar(String $calendarId)
    {
        return new JsonResponse($this->appCalendarService->getCalendars());
    }


    /**
     * @Route(methods={"POST"})
     * @param Request $request
     * @return string
     */
    public function createCalendar(Request $request)
    {
        return new Response(
            $this->serializer->serialize(
                new CalendarRepresentation(
                    $this->appCalendarService->createCalendar($request->get('name'), $request->get('description'))
                ),
                'json'
            )
        );
    }


    /**
     *
     * @Route(methods={"PUT"}, path="/calendar/{calendarId}")
     * @param Request $request
     * @param string $calendarId
     */
    public function changeCalendar($calendarId, Request $request)
    {

    }

    public function removeCalendar()
    {

    }
}
