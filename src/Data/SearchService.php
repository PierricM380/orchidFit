<?php

namespace App\Data;

use App\Entity\Service;

class SearchService
{
    /**
     * @var string
     */
    public $se = '';

    /**
     * @var Service[]
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