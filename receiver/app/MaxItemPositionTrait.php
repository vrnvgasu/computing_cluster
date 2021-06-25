<?php

namespace App;

trait MaxItemPositionTrait
{
    public function getMaxItemAndPositionFromArray(array $array): array
    {
        $maxItemPosition = 0;
        $maxItem = $array[0];

        foreach ($array as $k => $v) {
            if ($maxItem < $v) {
                $maxItem = $v;
                $maxItemPosition = $k;
            }
        }

        return [$maxItem, $maxItemPosition];
    }
}
