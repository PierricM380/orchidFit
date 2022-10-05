<?php

namespace App\Data;

use App\Entity\Partner;

class SearchPartner
{
    /**
     * @var string
     */
    public $q = '';

    /**
     * @var Partner[]
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
