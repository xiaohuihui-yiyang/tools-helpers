<?php

namespace DevTools\Helpers\Serialize\Strategy;

class Serialize implements \DevTools\Helpers\Serialize\Serialize
{

    public function decode($content)
    {
        return unserialize($content);
    }

    public function encode($param)
    {
        return serialize($param);
    }
}