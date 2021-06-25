<?php

namespace App;

class MaxMax
{
    public function handle(array $matrix): array
    {
        print_r($matrix);
        $maxItems = [];

        foreach ($matrix as $row) {
            $maxItems[] = max($row);
        }

        $maxItemPosition = 0;
        $maxItem = $maxItems[0];

        foreach ($maxItems as $i => $item) {
            if ($maxItem < $item) {
                $maxItem = $item;
                $maxItemPosition = $i;
            }
        }

        return [
            'max' => $maxItems,
            'i' => $maxItemPosition,
            'value' => $maxItem,
        ];
    }
}
