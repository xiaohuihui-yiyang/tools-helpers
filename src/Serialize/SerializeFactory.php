<?php

namespace DevTools\Helpers\Serialize;

use DevTools\Helpers\Exceptions\InvalidArgumentException;

class SerializeFactory
{
    public static function strategy($type)
    {
        $strategyClass = 'DevTools\\Helpers\\Serialize\\Strategy\\' . ucfirst($type);
        if (!class_exists($strategyClass)) {
            throw new InvalidArgumentException("无效的类型");
        }
        $strategy = new $strategyClass;
        return $strategy;
    }
}