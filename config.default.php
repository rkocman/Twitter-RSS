<?php

// FILL and RENAME to config.php

/**
 * Twitter RSS
 * Author: Radim Kocman
 */

namespace TwitterRSS;

/**
 * Database configuration.
 */
class DatabaseConfig
{
    const driver = 'mysqli';
    const host = 'localhost';
    const username = 'admin';
    const password = '';
    const database = 'test';
    const table = 'twitterrss';
}

/**
 * Admin configuration.
 */
class AdminConfig
{
    const username = 'admin';
    const password = '';
}

/**
 * Twitter configuration.
 */
class TwitterConfig
{
    const apiKey = '';
    const apiSecretKey = '';
}

/**
 * Application configuration.
 */
class AppConfig
{
    const devel = false;
    const debugResults = false;

    const cache = false;
    const cacheTime = 120; // in minutes

    const sessionName = 'twitterrss';

    // Maximum number of returned RSS items.
    const maxResults = 300; // max 800

    // This can remove emoji icons from the content for compatibility reasons.
    const removeEmoji = false;
}
