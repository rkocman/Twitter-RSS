<?php

/**
 * Twitter RSS
 * Author: Radim Kocman
 */

namespace TwitterRSS\Model\Services;

use Abraham\TwitterOAuth\TwitterOAuth;
use TwitterRSS\TwitterConfig;
use TwitterRSS\Utils\Links;
use TwitterRSS\Utils\Sessions;
use TwitterRSS\AppConfig;

/**
 * Twitter model.
 */
class Twitter
{
    /** @var \Abraham\TwitterOAuth\TwitterOAuth */
    private static $connection;

    /**
     * Inits the API objects.
     */
    public static function init()
    {
        self::$connection = new TwitterOAuth(TwitterConfig::apiKey, TwitterConfig::apiSecretKey);

        if (Sessions::$user->isConnected()) {
            self::$connection->setOauthToken(Sessions::$user->accessToken, Sessions::$user->accessTokenSecret);
        }
    }

    /**
     * Returns the authentication url.
     * @return string
     */
    public static function getAuthUrl()
    {
        $requestTokens = self::$connection->oauth('oauth/request_token', [
            'oauth_callback' => Links::generateFull()
        ]);
        Sessions::$user->accessToken = $requestTokens['oauth_token'];
        Sessions::$user->accessTokenSecret = $requestTokens['oauth_token_secret'];
        $url = self::$connection->url('oauth/authorize', [
            'oauth_token' => $requestTokens['oauth_token']
        ]);
        return $url;
    }

    /**
     * Gets the permanent access tokens.
     * @param string verifying code from the response
     * @return array
     */
    public static function getAccessTokens($oauthVerifier)
    {
        self::$connection->setOauthToken(Sessions::$user->accessToken, Sessions::$user->accessTokenSecret);
        $accessTokens = self::$connection->oauth('oauth/access_token', [
            'oauth_verifier' => $oauthVerifier
        ]);
        return [
            'accessToken' => $accessTokens['oauth_token'],
            'accessTokenSecret' => $accessTokens['oauth_token_secret']
        ];
    }

    /**
     * Gets tweets from the home timeline.
     * @return array
     */
    public static function getTimelineTweets()
    {
        $tweets = [];
        $maxCount = AppConfig::maxResults;
        $maxId = null;

        while ($maxCount > 0) {
            $params = [
                'count' => 200,
                'tweet_mode' => 'extended'
            ];
            if (isset($maxId)) {
                $params['max_id'] = $maxId;
            }
            $response = self::$connection->get('statuses/home_timeline', $params);
            if (isset($maxId)) {
                unset($response[0]);
            }
            foreach ($response as $item) {
                if ($maxCount > 0) {
                    $tweets[] = $item;
                    $maxCount--;
                    $maxId = $item->id;
                }
            }
        }
        
        return $tweets;
    }

}
