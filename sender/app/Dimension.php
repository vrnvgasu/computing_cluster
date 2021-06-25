<?php

namespace App;

class Dimension
{
    /**
     * @var array
     */
    public $vars;

    public function __construct(array $vars)
    {
        $this->vars = $vars;
    }
}
