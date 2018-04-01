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
     * @param \DateTimeImmutable $begins
     * @param \DateTimeImmutable $ends
     */
    public function __construct (\DateTimeImmutable $begins, \DateTimeImmutable $ends)
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
     * @param \DateTimeImmutable $begins
     * @param \DateTimeImmutable $ends
     */
    private function assertCorrectTimeSpan(\DateTimeImmutable $begins, \DateTimeImmutable $ends)
    {
        Assert::notNull($begins, 'The value for begins not provided');
        Assert::notNull($ends, 'The value for ends not provided');

        Assert::false($begins > $ends, 'The dates overlap');
    }
}