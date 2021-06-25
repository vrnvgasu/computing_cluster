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

    public function __construct()
    {
        $this->maxMixHandler = new MaxMax();
        $this->waldHandler = new Wald();
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
        ];
    }
}