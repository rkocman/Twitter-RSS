<?php

/**
 * Twitter RSS
 * Author: Radim Kocman
 */

namespace TwitterRSS\Model\Services;

use TwitterRSS\Utils\Sessions;
use TwitterRSS\Utils\Path;
use TwitterRSS\AppConfig;
use Nette\Caching;
use Nette\Caching\Storages\FileStorage;

/**
 * Cache for the results.
 */
class Cache 
{
    /** \Nette\Caching\Cache */
    private static $cache = null;

    /** @return \Nette\Caching\Cache  */
    private static function getCache()
    {
        if (self::$cache === null) {
            $storage = new FileStorage(Path::getTemp());
            self::$cache = new Caching\Cache($storage);
        }
        return self::$cache;
    }

    /**
     * Saves user's reults.
     */
    public static function saveResults($data)
    {
        $cache = self::getCache();
        $cache->save(Sessions::$user->id, $data, [
            Caching\Cache::EXPIRE => AppConfig::cacheTime.' minutes'
        ]);
    }

    /**
     * Loads user's results.
     */
    public static function loadResults()
    {
        $cache = self::getCache();
        return $cache->load(Sessions::$user->id);
    }

}
