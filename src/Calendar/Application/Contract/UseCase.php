<?php

namespace App\Calendar\Application;


interface UseCase
{
    /**
     * @return mixed
     */
    public function getManagedCommand();

    /**
     * @param CommandHandler $command
     * @return mixed
     */
    public function run(CommandHandler $command);
}
