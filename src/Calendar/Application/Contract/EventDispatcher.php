<?php

namespace App\Calendar\Application;


interface EventDispatcher
{
    /**
     * @param array $listeners
     * @return mixed
     */
    public function registerListeners(array $listeners);

    /**
     * @param $name
     * @param $event
     * @return mixed
     */
    public function notify($name, $event);
}