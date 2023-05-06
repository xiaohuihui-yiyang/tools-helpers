<?php

namespace DevTools\Helpers\Exceptions;

class InvalidArgumentException extends Exceptions
{
    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        return 'Invalid Argument';
    }
}