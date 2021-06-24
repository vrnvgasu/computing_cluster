<?php

namespace App;

class Task
{
    /**
     * @var Dimension
     */
    public $dimension;
    /**
     * @var Hurwitz
     */
    public $hurwitz;
    /**
     * @var Bayes
     */
    public $bayes;
    /**
     * @var string
     */
    private $id;

    public function __construct(Dimension $dimension, Hurwitz $hurwitz, Bayes $bayes)
    {
        $this->id = uniqid();
        $this->dimension = $dimension;
        $this->hurwitz = $hurwitz;
        $this->bayes = $bayes;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    public function __clone()
    {
        $this->id = uniqid();
    }
}
