<?php

namespace App\Calendar\Application;


use App\Calendar\Domain\Collection;

interface Command
{
    /**
     * @return Collection
     */
    public function getRequest();
}