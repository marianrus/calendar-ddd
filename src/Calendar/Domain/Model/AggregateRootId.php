<?php
declare(strict_types=1);

namespace App\Calendar\Domain\Model;

use Ramsey\Uuid\Uuid;

/**
 * Class AggregateRootId
 *
 * Its the unique identifier and will be auto-generated if not value is set.
 *
 */
abstract class AggregateRootId
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     */
    protected $uuid;

    /**
     * AggregateRootId constructor.
     * @param null|string $id
     */
    public function __construct(?string $id=null)
    {
        try {
            $this->uuid = Uuid::fromString($id ?: (string) Uuid::uuid4()->toString());
        }catch (\InvalidArgumentException $e) {
            //custom exception
            throw $e;
        }
    }

    /**
     * @param $id
     * @return static
     */
    public function fromString($id)
    {
        return new static($id);
    }

    /**
     * @param AggregateRootId $other
     * @return bool
     */
    public function equals(AggregateRootId $other)
    {
        return $this->uuid === $other->toString();
    }

    /**
     * @return string
     */
    public function toString() : string
    {
        return $this->uuid->toString();
    }
}