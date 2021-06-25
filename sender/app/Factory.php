<?php

namespace App;

class Factory
{
    const DIMENSION = 10;
    /**
     * @param int $taskCount
     * @return array<Task>
     */
    public function generateTasks(int $taskCount): array
    {
        $tasks = [];
        $protorype = $this->generateTask();

        for ($i = 0; $i < $taskCount; $i++) {
            $tasks[] = clone($protorype);
        }

        return $tasks;
    }

    public function generateTask(): Task
    {
        $dimensionVars = [];

        for ($i = 0; $i < static::DIMENSION; $i++) {
            for ($j = 0; $j < static::DIMENSION; $j++) {
                $dimensionVars[$i][$j] = $i + rand(1, 10) - $j - rand(1, 10);
            }
        }

        $dimension = new Dimension($dimensionVars);
        $hurwitz = new Hurwitz(rand(1, 10) / 100, rand(1, 10) / 100);

        $probabilities = [];
        $sum = 0;
        $several = (int)round(100000 / static::DIMENSION);


        for ($i = 0; $i < static::DIMENSION; $i++) {
            $probability = $several + (rand(0, 1) ? -1 : 1);
            $probabilities[] = $probability / 100000;
            $sum += $probability;
        }

        $probabilitiesIndex = rand(0, count($probabilities) - 1);
        $probabilities[$probabilitiesIndex] = $probabilities[$probabilitiesIndex] + (100000 - $sum) / 100000;

        $bayes = new Bayes($probabilities);

        return new Task($dimension, $hurwitz, $bayes);
    }
}
