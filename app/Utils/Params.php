<?php

/**
 * Twitter RSS
 * Author: Radim Kocman
 */

namespace TwitterRSS\Utils;

/**
 * Handler for the app parameters.
 */
class Params
{
  // Parameters used for navigation in the app.
  public static $section;
  public static $action;
  public static $id;
  
  // Parameters used for the authentication.
  public static $oauthToken;
  public static $oauthVerifier;
  
  /**
   * Loads parameters from the page reguest.
   */
  public static function init()
  {
    self::$section = isset($_GET['section'])? $_GET['section'] : '';
    self::$action = isset($_GET['action'])? $_GET['action'] : '';
    self::$id = isset($_GET['id'])? $_GET['id'] : '';
    
    self::$oauthToken = isset($_GET['oauth_token'])? $_GET['oauth_token'] : null;
    self::$oauthVerifier = isset($_GET['oauth_verifier'])? $_GET['oauth_verifier'] : null;
  }
  
}
