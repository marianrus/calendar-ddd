<?php

namespace App\Calendar\Application\Event;


use App\Calendar\Application\Command;

class PreCommandEvent
{
    /**
     * @var Command
     */
    private $command;

    /**
     * PreCommandEvent constructor.
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
