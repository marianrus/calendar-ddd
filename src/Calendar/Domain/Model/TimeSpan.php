<?php

namespace App\Calendar\Domain\Model;


use Broadway\Domain\DateTime;
use Webmozart\Assert\Assert;

final class TimeSpan
{
    /**
     * @var DateTime
     */
    private $begins;

    /**
     * @var DateTime
     */
    private $ends;

    /**
     * TimeSpan constructor.
     * @param DateTime $begins
     * @param DateTime $ends
     */
    public function __construct (DateTime $begins, DateTime $ends)
    {
        $this->assertCorrectTimeSpan($begins, $ends);
        $this->begins = $begins;
        $this->ends = $ends;
    }

    /**
     * @return DateTime
     */
    public function getBegins (): DateTime
    {
        return $this->begins;
    }

    /**
     * @return DateTime
     */
    public function getEnds (): DateTime
    {
        return $this->ends;
    }

    /**
     * @param DateTime $begins
     * @param DateTime $ends
     */
    private function assertCorrectTimeSpan(DateTime $begins, DateTime $ends)
    {
        Assert::notNull($begins, 'The value for begins not provided');
        Assert::notNull($ends, 'The value for ends not provided');

        Assert::false($begins->comesAfter($ends));
    }
}