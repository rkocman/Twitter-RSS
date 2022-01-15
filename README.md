Twitter RSS
========
This application creates an RSS feed of your home timeline. It is designed as a web application that should run on a server and that can maintain multiple independent accounts for several users.

The resulting RSS resembles the old official export that was available on Twitter in the past. But it also incorporates new features that did not exist back then (long tweets, media content).

**Project status:** completed (maintained)


## Installation Guide

To set up the application you will need several things beforehand:
1. A web server that supports PHP (>=7.3) and MySQL
2. Dependency Manager for PHP: [Composer](https://getcomposer.org/)
3. Own [Twitter App](https://developer.twitter.com/) to access Twitter API

The installation process follows: 
1. Clone or download this repository
2. Install all dependencies with Composer: `composer install`
3. Fill `config.default.php` and rename it to `config.php`
4. Upload the app to the server
5. Run the app and log in as the admin
6. Initialize the database for regular users
7. Try to create a user account to check if everything is set correctly
8. ?
9. PROFIT!


## User Guide

Just follow instructions in the app: First, sign up with some username and password. Second, connect the account with your Twitter. Now, you should be able to generate the RSS feed.

To access the RSS feed directly just use its URL and appropriate credentials.


## License
MIT License
