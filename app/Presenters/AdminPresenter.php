<?php

/**
 * Twitter RSS
 * Author: Radim Kocman
 */

namespace TwitterRSS\Presenters;

use TwitterRSS\Utils\Sessions;
use TwitterRSS\Utils\Params;
use TwitterRSS\Utils\Links;
use TwitterRSS\Utils\Latte;
use TwitterRSS\Model\Services\Db;

/**
 * Presenter for the admin section.
 */
class AdminPresenter
{
    /**
     * Selects an action.
     */
    public static function run()
    {
        // login
        if (Sessions::$admin->isLogged() === false) {
            Sessions::$admin->login();
        }

        // summary
        if (empty(Params::$action)) {
            self::summary(); 
            return;
        }

        // create table
        if (Params::$action === 'create-table') {
            self::createTable(); 
            return;
        }

        die(header('Location: '.Links::generateFull('admin')));
    }

    /**
     * Page: Summary.
     */
    public static function summary()
    {
        $params = [
            'check' => Db::checkTable(),
            'summary' => Db::getSummary()
        ];
        Latte::render('Admin/summary.latte', $params);
    }
    
    /**
     * Action: Create the table.
     */
    public static function createTable()
    {
        Db::createTable();
        die(header('Location: '.Links::generateFull('admin')));
    }

}
