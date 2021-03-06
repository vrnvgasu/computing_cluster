<?php

namespace App;

class Calculation
{
    /**
     * @var MaxMax
     */
    private $maxMixHandler;
    /**
     * @var Wald
     */
    private $waldHandler;
    /**
     * @var Savage
     */
    private $savageHandler;
    /**
     * @var Hurwitz
     */
    private $hurwitzHandler;
    /**
     * @var Bayes
     */
    private $bayesHandler;
    /**
     * @var Laplace
     */
    private $laplaceHandler;

    public function __construct()
    {
        $this->maxMixHandler = new MaxMax();
        $this->waldHandler = new Wald();
        $this->savageHandler = new Savage();
        $this->hurwitzHandler = new Hurwitz();
        $this->bayesHandler = new Bayes();
        $this->laplaceHandler = new Laplace();
    }

    public function handle(array $data): array
    {
        $id = $data['id'];
        $matrix = $data['matrix'];
        $hurwitz = $data['hurwitz'];
        $bayes = $data['bayes'];

        return [
            'id' => $id,
            'maxMax' => $this->maxMixHandler->handle($matrix),
            'wald' => $this->waldHandler->handle($matrix),
            'savage' => $this->savageHandler->handle($matrix),
            'hurwitz' => $this->hurwitzHandler->handle($matrix, $hurwitz),
            'bayes' => $this->bayesHandler->handle($matrix, $bayes),
            'laplace' => $this->laplaceHandler->handle($matrix),
        ];
    }
}