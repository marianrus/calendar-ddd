<?php

namespace App\Calendar\Application\Representation;


class ErrorRepresentation
{

    private $error;

    private $errorDescription;


    public function __construct ($error, $errorDescription)
    {
        $this->error = $error;
        $this->errorDescription = $errorDescription;
    }
}