<?php

namespace App\Calendar\Application;


interface Validator
{
    /**
     * @param $value
     * @return mixed
     */
    public function validate($value);
}