<?php

namespace App\Calendar\Infrastructure\Persistence\ORM\Doctrine\Repository;


use App\Calendar\Domain\Model\CalendarEvent;
use App\Calendar\Domain\Model\CalendarEventId;
use App\Calendar\Domain\Repository\CalendarEventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

class ORMCalendarEventRepository implements CalendarEventRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $internalRepository;

    /**
     * ORMCalendarRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->internalRepository = $this->em->getRepository(CalendarEvent::class);
    }

    /**
     * @param CalendarEventId $calendarId
     * @return CalendarEvent
     */
    public function getById(CalendarEventId $calendarId) : CalendarEvent
    {
       return $this->internalRepository->find(
            $calendarId->id()
        );
    }

    /**
     * @return CalendarEventId
     */
    public function nextIdentity() : CalendarEventId
    {
        return new CalendarEventId(Uuid::uuid4()->toString());
    }

    /**
     * @param CalendarEvent $calendarEvent
     */
    public function save(CalendarEvent $calendarEvent) : void
    {
        $this->em->persist($calendarEvent);
        $this->em->flush();
    }

    /**
     * @param CalendarEvent $calendarEvent
     */
    public function remove (CalendarEvent $calendarEvent): void
    {
        $this->em->remove($calendarEvent);
    }
}