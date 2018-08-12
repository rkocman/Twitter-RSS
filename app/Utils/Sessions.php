<?php

/**
 * Twitter RSS
 * Author: Radim Kocman
 */

namespace TwitterRSS\Utils;

use TwitterRSS\Model\Users;
use TwitterRSS\AppConfig;

/**
 * Session handler.
 */
class Sessions
{
    /** @var \TwitterRSS\Model\Users\RegisteredUser */
    public static $user;
    
    /** @var \TwitterRSS\Model\Users\Admin */
    public static $admin;
    
    /** Remembers if the user tried to log out. */
    public static $logout;

    /**
     * Initializes session variables.
     */
    public static function init()
    {
        session_start();

        if (!isset($_SESSION[AppConfig::sessionName])) {
            $_SESSION[AppConfig::sessionName] = [
                'user' => self::resetUser(),
                'admin' => self::resetAdmin(),
                'logout' => false
            ];
        }
        
        self::$user = $_SESSION[AppConfig::sessionName]['user'];
        self::$admin = $_SESSION[AppConfig::sessionName]['admin'];
        self::$logout = $_SESSION[AppConfig::sessionName]['logout'];
    }

    /**
     * Creates a new instance of the registered user.
     * @return \TwitterRSS\Model\Users\RegisteredUser
     */
    public static function resetUser()
    {
        self::$user = new Users\RegisteredUser;
        $_SESSION[AppConfig::sessionName]['user'] = self::$user;
        return self::$user;
    }

    /**
     * Creates a new instance of the admin user.
     * @return \TwitterRSS\Model\Users\Admin
     */
    public static function resetAdmin()
    {
        self::$admin = new Users\Admin;
        $_SESSION[AppConfig::sessionName]['admin'] = self::$admin;
        return self::$admin;
    }

    /**
     * Closes PHP_AUTH.
     */
    public static function closePHPAuth()
    {
        $_SESSION[AppConfig::sessionName]['logout'] = true;
    }
    
    /**
     * Resets PHP_AUTH.
     */
    public static function resetPHPAuth()
    {
        $_SESSION[AppConfig::sessionName]['logout'] = false;
    }

}
