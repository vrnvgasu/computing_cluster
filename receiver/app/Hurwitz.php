<?php

namespace App;

class Hurwitz
{
    use MaxItemPositionTrait;

    /**
     * @param array<array> $matrix
     * @param array<string,float> $hurwitz
     * @return array
     */
    public function handle(array $matrix, array $hurwitz): array
    {
        $minAndMaxItems = [];

        foreach ($matrix as $row) {
            $items = [];
            $items[] = min($row);
            $items[] = max($row);
            $minAndMaxItems[] = $items;
        }

        $results1 = [];
        foreach ($minAndMaxItems as $row) {
            $g = $hurwitz['var1'] * $row[0] + (1 - $hurwitz['var1']) * $row[1];
            $results1[] = round($g, 2);
        }

        $results2 = [];
        foreach ($minAndMaxItems as $row) {
            $g = $hurwitz['var2'] * $row[0] + (1 - $hurwitz['var2']) * $row[1];
            $results2[] = round($g, 2);
        }

        $strategy1 = $this->getMaxItemAndPositionFromArray($results1);
        $strategy2 = $this->getMaxItemAndPositionFromArray($results2);

        return [
            [
                'λ' => $hurwitz['var1'],
                'G' => $results1,
                'i' => $strategy1[1],
                'value' => $strategy1[0],
            ],
            [
                'λ' => $hurwitz['var2'],
                'G' => $results2,
                'i' => $strategy2[1],
                'value' => $strategy2[0],
            ],
        ];
    }
}
