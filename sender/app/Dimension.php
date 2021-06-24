<?php

namespace App;

class Dimension
{
    /**
     * @var int
     */
    public $n;

    public function __construct(int $n)
    {
        $this->n = $n;
    }
}
