<?php

namespace App;

class Savage
{
    public function handle(array $matrix): array
    {
        $maxItems = [];
        $riskMatrix = $this->getRiskMatrix($matrix);

        foreach ($riskMatrix as $row) {
            $maxItems[] = max($row);
        }

        $minItemPosition = 0;
        $minItem = $maxItems[0];

        foreach ($maxItems as $i => $item) {
            if ($minItem > $item) {
                $minItem = $item;
                $minItemPosition = $i;
            }
        }

        return [
            'riskMatrixMax' => $maxItems,
            'i' => $minItemPosition,
            'value' => $minItem,
        ];
    }

    private function getRiskMatrix(array $matrix): array
    {
        $riskMatrix = [];

        for ($i = 0; $i < count($matrix); $i++) {
            $riskMatrix[] = $matrix[$i];
        }

        for ($j = 0; $j < count($matrix[0]); $j++) {
            $maxColumnItem = null;

            for ($i = 0; $i < count($matrix); $i++) {
                if ($maxColumnItem === null || $maxColumnItem < $matrix[$i][$j]) {
                    $maxColumnItem = $matrix[$i][$j];
                }
            }

            for ($i = 0; $i < count($matrix); $i++) {
                $riskMatrix[$i][$j] = $maxColumnItem - $matrix[$i][$j];
            }
        }

        return $riskMatrix;
    }
}
