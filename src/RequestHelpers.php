<?php

namespace DevTools\Helpers;

class RequestHelpers extends BaseHelpers
{
    public static function IsHttps()
    {
        if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off') {
            return true;
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            return true;
        } elseif (!empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) != 'off') {
            return true;
        }
        return false;
    }


}