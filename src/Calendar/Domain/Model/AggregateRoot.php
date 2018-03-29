<?php

namespace App\Calendar\Domain\Model;


class AggregateRoot
{
    /**
     * @var string
     */
    protected $uuid;

    protected function __construct(AggregateRootId $aggregateRootId)
    {
        $this->uuid = $aggregateRootId;
    }

}