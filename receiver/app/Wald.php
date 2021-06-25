<?php

namespace App;

class Wald
{
    public function handle(array $matrix): array
    {
        $minItems = [];

        foreach ($matrix as $row) {
            $minItems[] = min($row);
        }

        $maxItemPosition = 0;
        $maxItem = $minItems[0];

        foreach ($minItems as $i => $item) {
            if ($maxItem < $item) {
                $maxItem = $item;
                $maxItemPosition = $i;
            }
        }

        return [
            'min' => $minItems,
            'i' => $maxItemPosition,
            'value' => $maxItem,
        ];
    }
}
