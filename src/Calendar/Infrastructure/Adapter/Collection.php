<?php

namespace App\Calendar\Infrastructure;
use App\Calendar\Domain\Collection as DomainCollection;
use Doctrine\Common\Collections\ArrayCollection;


class Collection extends ArrayCollection implements DomainCollection
{

}