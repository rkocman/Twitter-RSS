<?php

/**
 * Twitter RSS
 * Author: Radim Kocman
 */

namespace TwitterRSS\Model\Users;

use TwitterRSS\Utils\Sessions;
use TwitterRSS\Model\Services\Db;
use TwitterRSS\Model\Services\Twitter;
use TwitterRSS\Constants;
use Nette\Security\Passwords;

/**
 * Registered user of the app.
 */
class RegisteredUser
{
    /* users's login status */
    private $logged;

    // user's data
    public $id;
    public $username;
    private $connected;
    public $accessToken;
    public $accessTokenSecret;

    public function __construct()
    {
        $this->logged = false;
        $this->connected = false;
    }

    /**
     * Is the user logged in?
     * @return bool
     */
    public function isLogged()
    {
        return $this->logged;
    }

    /**
     * Is the user connected with Twitter?
     * @return bool
     */
    public function isConnected()
    {
        return $this->connected;
    }

    /**
     * Performs a login attempt.
     */
    public function login()
    {
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])
            && Sessions::$logout === false)
        {
            $data = Db::getUserData($_SERVER['PHP_AUTH_USER']);
            if (!empty($data)) {
                if (Passwords::verify($_SERVER['PHP_AUTH_PW'], $data['password'])) {
                $this->id = $data['id'];
                $this->username = $data['username'];
                $this->logged = true;
                if (!empty($data['accessToken'])) {
                    $this->accessToken = $data['accessToken'];
                    $this->accessTokenSecret = $data['accessTokenSecret'];
                    $this->connected = true;
                    Twitter::init();
                }
                return;
                }
            }
        }
        
        Sessions::resetPHPAuth();
        Header('WWW-Authenticate: Basic realm="'.Constants::title.'"');
        Header('HTTP/1.0 401 Unauthorized');
        exit;
    }

    /**
     * Performs the logout.
     */
    public function logout()
    {
        Sessions::resetUser();
        Sessions::closePHPAuth();
    }

    /**
     * Signs up a new user.
     * @param string username
     * @param string password
     * @return bool
     */
    public function signUp($username, $password)
    {
        $id = Db::insertUser($username, Passwords::hash($password));
        if ($id < 0) {
            return false;
        }
        
        $this->id = $id;
        $this->username = $username;
        $this->logged = true;
        return true;
    }

    /**
     * Saves Twitter tokens.
     * @param string accessToken
     * @param string accessTokenSecret
     */
    public function saveTokens($accessToken, $accessTokenSecret)
    {
        Db::updateTokens($this->username, $accessToken, $accessTokenSecret);
        $this->accessToken = $accessToken;
        $this->accessTokenSecret = $accessTokenSecret;
        $this->connected = true;
    }

}
