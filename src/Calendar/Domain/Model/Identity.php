<?php

namespace App\Calendar\Domain\Model;


interface Identity
{
    /**
     * @return string
     */
    public function id() : string;
}