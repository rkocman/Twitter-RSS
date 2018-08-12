<?php

/**
 * Twitter RSS
 * Author: Radim Kocman
 */

namespace TwitterRSS;

use Tracy\Logger;


/**
 * This class controls the whole app.
 */
class Engine
{
    
    public static function run()
    {
        try {

            Utils\Params::init();
            Utils\Sessions::init();
            Model\Services\Db::init();
            Model\Services\Twitter::init();

            Presenters\Router::run();
            
        /// Exception handling
        } catch (\Exception $e) {
            if (AppConfig::devel) {
                throw $e;
            }
            Logger::log($e);
            if ($e instanceof \Dibi\Exception) {
                Presenters\AppPresenter::showError('Some SQL error has occured!');
            } else {
                Presenters\AppPresenter::showError('Some unexpected error has occurred!');
            }
        }
        ///
    }

}
