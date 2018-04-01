<?php

namespace App\Calendar\Domain\Model;


use Webmozart\Assert\Assert;

abstract class AbstractId implements Identity
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * CalendarId.yml constructor.
     * @param $anId
     */
    public function __construct($anId)
    {
        $this->setId($anId);
    }

    /**
     * @param $anId
     * @return static
     */
    public static function fromString($anId)
    {
        return new static($anId);
    }

    /**
     * @param AbstractId $anObject
     * @return bool
     */
    public function equals(AbstractId $anObject)
    {
        Assert::notNull($anObject);

        return $this->id() == $anObject->id();
    }

    /**
     * @param $anId
     */
    private function setId($anId)
    {
        Assert::notEmpty($anId, 'The ID is required');
        Assert::notNull($anId, 'The ID is null');

        $this->id = $anId;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function __toString ()
    {
        return $this->id;
    }
}