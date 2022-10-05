<?php

namespace App\Data;

use App\Entity\Structure;

class SearchStructure
{
    /**
     * @var string
     */
    public $s = '';

    /**
     * @var Structure[]
     */
    public $name = [];

    /**
     * @var boolean
     */
    public $isActive = false;

    /**
     * @var boolean
     */
    public $isDisabled;
}
