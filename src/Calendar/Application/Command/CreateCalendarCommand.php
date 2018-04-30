<?php

namespace App\Calendar\Application;


use App\Calendar\Infrastructure\Collection;

class CreateCalendarCommand implements Command
{
    /**
     * @var
     */
    private $name;

    /**
     * @var
     */
    private $description;

    /**
     * CreateCalendarCommand constructor.
     * @param $name
     * @param $description
     */
    public function __construct($name, $description)
    {
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * @return Collection
     */
    public function getRequest()
    {
       return new Collection([
           'name'=> $this->name,
           'description' => $this->description
       ]);
    }
}