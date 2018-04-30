<?php

namespace App\Calendar\Application\Event;


use App\Calendar\Application\Command;

class ExceptionCommandEvent
{
    /**
     * @var Command
     */
    private $command;

    /**
     * PostCommandEvent constructor.
     * @param Command $command
     */
    public function __construct(Command $command)
    {
        $this->command = $command;
    }

    /**
     * @return Command
     */
    public function getCommand()
    {
        return $this->command;
    }
}
