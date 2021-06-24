<?php

namespace App;

class Bayes
{
    /**
     * @var float[]
     */
    public $probabilities;

    /**
     * Bayes constructor.
     * @param array<float> $probabilities
     */
    public function __construct(array $probabilities)
    {
        $sum = 0;

        foreach ($probabilities as $probability) {
            if ($probability >= 1 || $probability <= 0) {
                throw new \LogicException('Probability must be in the range [0, 1]');
            }

            $sum += (int)($probability * 100000);
        }

        $this->probabilities = $probabilities;
    }
}
