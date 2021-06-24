<?php

namespace App;

class Factory
{
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
        $dimension = new Dimension(1000);
        $hurwitz = new Hurwitz(rand(1, 10) / 100, rand(1, 10) / 100);

        $probabilities = [];
        $sum = 0;
        $several = (int)round(100000 / $dimension->n);


        for ($i = 0; $i < $dimension->n; $i++) {
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
