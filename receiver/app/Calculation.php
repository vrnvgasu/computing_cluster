<?php

namespace App;

class Calculation
{
    /**
     * @var MaxMax
     */
    private $maxMixHandler;

    public function __construct()
    {
        $this->maxMixHandler = new MaxMax();
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
        ];
    }
}