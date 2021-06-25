<?php

namespace App;

class Bayes
{
    use MaxItemPositionTrait;

    /**
     * @param array<array> $matrix
     * @param array<float> $probabilities
     * @return array
     */
    public function handle(array $matrix, array $probabilities): array
    {
        $results = [];

        foreach ($matrix as $row) {
            $sum = 0;

            for ($j = 0; $j < count($row); $j++) {
                $sum += ($row[$j] * $probabilities[$j]);
            }

            $results[] = round($sum, 2);
        }

        $strategy = $this->getMaxItemAndPositionFromArray($results);

        return [
            'max' => $results,
            'i' => $strategy[1],
            'value' => $strategy[0],
        ];
    }
}
