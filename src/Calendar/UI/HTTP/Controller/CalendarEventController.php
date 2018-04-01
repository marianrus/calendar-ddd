<?php

namespace App\Calendar\UI\HTTP\Controller;


use App\Calendar\Application\CalendarApplicationService;
use App\Calendar\Application\CalendarEventApplicationService;
use App\Calendar\Application\Exception\CalendarEventNotFoundException;
use App\Calendar\Application\Exception\CalendarNotFoundException;
use App\Calendar\Application\Representation\CalendarEventRepresentation;
use App\Calendar\Domain\Model\CalendarEventId;
use App\Calendar\Domain\Model\CalendarId;
use App\Calendar\Domain\Repository\CalendarEventRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Nelmio\ApiDocBundle\Annotation\S;

class CalendarEventController
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var CalendarApplicationService
     */
    private $calendarApplicationService;

    /**
     * @var CalendarEventApplicationService
     */
    private $calendarEventApplicationService;

    /**
     * @var CalendarEventRepository
     */
    private $calendarEventRepository;

    /**
     * CalendarEventController constructor.
     * @param SerializerInterface $serializer
     * @param CalendarApplicationService $calendarApplicationService
     * @param CalendarEventApplicationService $calendarEventApplicationService
     * @param CalendarEventRepository $calendarEventRepository
     */
    public function __construct (
        SerializerInterface $serializer,
        CalendarApplicationService $calendarApplicationService,
        CalendarEventApplicationService $calendarEventApplicationService,
        CalendarEventRepository $calendarEventRepository
    ){
        $this->serializer = $serializer;
        $this->calendarApplicationService = $calendarApplicationService;
        $this->calendarEventApplicationService = $calendarEventApplicationService;
        $this->calendarEventRepository = $calendarEventRepository;
    }

    /**
     * @SWG\Post(
     *     path="/calendar/{calendarId}/events",
     *     summary="Retrieves the event list associated with a calendar."
     *     @SWG\Response(
     *         response=200,
     *         description="Success",
     *         @SWG\Schema(ref="#/definitions/MoviesViewDTO"),
     *     )
     * )
     *
     * @Rest\Route(
     *     path="/calendar/{calendarId}/events",
     *     methods={"POST"}
     * )
     */
    public function scheduleCalendarEvent($calendarId, Request $request)
    {
        try{
            $scheduledEvent = $this->calendarApplicationService
                ->scheduleCalendarEvent(
                    new CalendarId($calendarId),
                    $request->get('description'),
                    $request->get('location'),
                    new \DateTimeImmutable($request->get('begins')),
                    new \DateTimeImmutable($request->get('ends')),
                    $request->get('comment')
                );

            return new Response(
                $this->serializer->serialize(new CalendarEventRepresentation($scheduledEvent), 'json'),
                Response::HTTP_CREATED
            );
        }catch(CalendarNotFoundException $e) {
            throw new HttpException(404, $e->getMessage());
        }catch(\Exception $e) {
            throw new HttpException(404, $e->getMessage());
        }
    }

    /**
     * @Rest\Route(
     *     path="/calendar/{calendarId}/events/{calendarEventId}",
     *     methods={"PUT"}
     * )
     *
     * @param $calendarEventId
     * @param Request $request
     * @return Response
     */
    public function reScheduleCalendarEvent($calendarEventId,  Request $request)
    {
        try{
            $reScheduledEvent = $this->calendarEventApplicationService
                ->reScheduleCalendarEvent(
                    CalendarEventId::fromString($calendarEventId),
                    $request->get('description'),
                    $request->get('location'),
                    new \DateTimeImmutable($request->get('begins')),
                    new \DateTimeImmutable($request->get('ends')),
                    $request->get('comment')
                );

            $this->calendarEventRepository->save($reScheduledEvent);

            return new Response(
                $this->serializer->serialize(new CalendarEventRepresentation($reScheduledEvent), 'json'),
                Response::HTTP_OK
            );
        }catch(CalendarNotFoundException $ex) {
            throw new HttpException(404, $ex->getMessage());
        }catch(\InvalidArgumentException $e) {
            throw new HttpException(400, $e->getMessage());
        } catch(\Exception $e) {
            throw new HttpException(400, $e->getMessage());
        }
    }

    /**
     *
     * @param $calendarEventId
     * @throws \HttpException
     *
     */
    public function cancelEvent($calendarEventId)
    {
        try{
            $this->calendarEventApplicationService->cancelByCalendarEvent($calendarEventId);
        }catch(CalendarEventNotFoundException $e){
            throw new \HttpException($e->getMessage(), Response::HTTP_NO_CONTENT);
        }
    }
}

