<?php

namespace DevTools\Helpers\Serialize;


class SerializeContext
{
    /**
     * @var Serialize
     */
    private $strategy;

    public function __construct(Serialize $serialize)
    {
        return $this->strategy = $serialize;
    }

    public function encode($params)
    {
        return $this->strategy->encode($params);
    }

    public function decode($content)
    {
        return $this->strategy->decode($content);
    }
}