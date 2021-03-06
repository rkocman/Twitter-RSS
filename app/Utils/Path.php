<?php

/**
 * Twitter RSS
 * Author: Radim Kocman
 */

namespace TwitterRSS\Utils;

/**
 * This class serves paths for various derictories.
 */
class Path 
{

    public static function getTemp()
    {
        return __DIR__.'/../../temp/';
    }

    public static function getViews()
    {
        return __DIR__.'/../Views/';
    }
    
}
