<?php

namespace App\Calendar\Domain\Model;


use Webmozart\Assert\Assert;

abstract class AbstractId
{
    /**
     * @var
     */
    private $id;

    /**
     * @return string
     */
    public function id (): string
    {
        return $this->id;
    }

    /**
     * CalendarId constructor.
     * @param $anId
     */
    public function __construct ($anId)
    {
        Assert::notEmpty($anId, 'The ID is required');
        Assert::maxLength($anId, 'Max length exceeded');

        $this->id = $anId;
    }
}