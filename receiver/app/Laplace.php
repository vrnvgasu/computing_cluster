<?php

namespace App;

class Laplace
{
    use MaxItemPositionTrait;

    /**
     * @param array<array> $matrix
     * @return array
     */
    public function handle(array $matrix): array
    {
        $average = round(1 / count($matrix[0]), 5);
        $probabilities = [];

        for ($j = 0; $j < count($matrix[0]); $j++) {
        $probabilities[] = $average;
        }

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
