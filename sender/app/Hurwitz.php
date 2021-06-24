<?php

namespace App;

class Hurwitz
{
    /**
     * @var float
     */
    public $var1;
    /**
     * @var float
     */
    public $var2;

    public function __construct(float $var1, float $var2)
    {
        if ($var1 >= 1 || $var1 <=0 || $var2 >= 1 || $var2 <=0) {
            throw new \LogicException('Indicator must be in the range (0, 1');
        }

        $this->var1 = $var1;
        $this->var2 = $var2;
    }
}
