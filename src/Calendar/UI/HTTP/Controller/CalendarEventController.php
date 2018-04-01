<?php

namespace App\Calendar\UI\HTTP\Controller;


use App\Calendar\Application\CalendarApplicationService;
use App\Calendar\Application\CalendarEventApplicationService;
use App\Calendar\Application\Exception\CalendarEventNotFoundException;
use App\Calendar\Application\Exception\CalendarNotFoundException;
use App\Calendar\Application\Representation\CalendarEventListRepresentation;
use App\Calendar\Application\Representation\CalendarEventRepresentation;
use App\Calendar\Application\Representation\ErrorRepresentation;
use App\Calendar\Domain\Model\CalendarEventId;
use App\Calendar\Domain\Model\CalendarId;
use App\Calendar\Domain\Repository\CalendarEventRepository;
use App\Calendar\UI\Console\Calendar;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\VarDumper\VarDumper;

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
     * @Rest\Route(
     *     path="/calendar/{calendarId}/events",
     *     methods={"GET"}
     * )
     *
     * @param $calendarId
     * @return Response
     */
    public function getCalendarEvents($calendarId)
    {
        return new Response(
            $this->serializer->serialize(
                 new CalendarEventListRepresentation(
                     $this->calendarEventRepository->getByCalendarId(
                         CalendarId::fromString($calendarId)
                     )
                 ),
                'json'
            ),
            Response::HTTP_OK
        );
    }

    /**
     * @SWG\Post()
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
            throw new HttpException(Response::HTTP_NOT_FOUND, $ex->getMessage());
        }catch(\InvalidArgumentException $e) {
            throw new HttpException(400, $e->getMessage());
        } catch(\Exception $e) {
            throw new HttpException(400, $e->getMessage());
        }
    }

    /**
     * @Rest\Route(
     *     path="/calendar/{calendarId}/events/{calendarEventId}",
     *     methods={"DELETE"}
     * )
     *
     * @param $calendarEventId
     * @return string|Response
     */
    public function cancelEvent($calendarEventId)
    {
        try{
            $this->calendarEventApplicationService->cancelByCalendarEvent(CalendarEventId::fromString($calendarEventId));

            return new Response([], Response::HTTP_NO_CONTENT);
        }catch(CalendarEventNotFoundException $e){
            return $this->getErrorMessage($e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @param $message
     * @param $description
     * @return Response
     */
    private function getErrorMessage($message, $description)
    {
        return new Response($this->serializer->serialize(
                    new ErrorRepresentation(
                        $message,
                        $description
                    ), 'json'
                ),
            Response::HTTP_NOT_FOUND
        );
    }
}

