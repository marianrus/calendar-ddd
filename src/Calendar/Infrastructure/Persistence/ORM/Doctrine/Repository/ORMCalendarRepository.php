<?php

namespace App\Calendar\Infrastructure\Persistence\ORM\Doctrine\Repository;


use App\Calendar\Domain\Model\Calendar;
use App\Calendar\Domain\Model\CalendarEventId;
use App\Calendar\Domain\Model\CalendarId;
use App\Calendar\Domain\Repository\CalendarRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

class ORMCalendarRepository implements CalendarRepository
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
        $this->internalRepository = $this->em->getRepository(Calendar::class);
    }

    /**
     * @param CalendarId $calendarId
     * @return Calendar
     */
    public function getById(CalendarId $calendarId) : Calendar
    {
        return $this->internalRepository->find(
            $calendarId->id()
        );
    }

    /**
     * @return Calendar[]
     */
    public function getAll()
    {
        return $this->internalRepository->findAll();
    }

    /**
     * @return CalendarId
     */
    public function nextIdentity() : CalendarId
    {
        return new CalendarId(Uuid::uuid4()->toString());
    }

    /**
     * @param Calendar $calendar
     */
    public function save(Calendar $calendar): void
    {
        $this->em->persist($calendar);
        $this->em->flush();
    }
}
