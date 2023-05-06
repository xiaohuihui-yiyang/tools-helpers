<?php

namespace DevTools\Helpers\Serialize;

interface Serialize
{
    public function decode($content);

    public function encode($param);
}