<?php

/**
 * Twitter RSS
 * Author: Radim Kocman
 */

namespace TwitterRSS\Presenters;

use TwitterRSS\Utils\Sessions;
use TwitterRSS\Utils\Links;
use TwitterRSS\Utils\Latte;
use TwitterRSS\Model\Services\Db;
use TwitterRSS\Model\Services\Twitter;
use TwitterRSS\Model\Services\Cache;
use TwitterRSS\AppConfig;

/**
 * Presenter for RSS functions.
 */
class RSSPresenter
{
    
    /**
     * Page: RSS.
     */
    public static function run()
    {
        // login
        if (Sessions::$user->isLogged() === false) {
            Sessions::$user->login();
        }

        // connected
        if (Sessions::$user->isConnected() === false) {
            die(header('Location: '.Links::generateFull()));
        }

        // increase the use counter
        Db::updateUseCounter(Sessions::$user->username);

        // get data
        $data = null;
        if (AppConfig::cache) {
            $data = Cache::loadResults();
        }
        if ($data === null) {
            $data = Twitter::getTimelineTweets();
            if (AppConfig::cache) {
                Cache::saveResults($data);
            }
        }

        // debug results
        if (AppConfig::debugResults) {
            dump($data);
            exit;
        }

        // RSS
        $params = [
            'tweets' => $data
        ];
        Latte::render('RSS/rss.latte', $params);
    }

}
