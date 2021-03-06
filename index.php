<?php

/**
 * Twitter RSS
 * Author: Radim Kocman
 */

namespace TwitterRSS;

use Tracy\Debugger;
use Nette\Loaders\RobotLoader;
use Tracy\Bridges\Nette\Bridge;

// load a config
require_once __DIR__.'/config.php';

// composer autoloader
require_once __DIR__.'/vendor/autoload.php';

// tracy debugger
$mode = (AppConfig::devel)? Debugger::DEVELOPMENT : Debugger::PRODUCTION;
Debugger::enable($mode, __DIR__.'/log');
Debugger::$maxDepth = 8;
Debugger::$maxLength = 500;
Bridge::initialize();

// robot loader for the app
$loader = new RobotLoader;
$loader->addDirectory(__DIR__.'/app');
$loader->setTempDirectory(__DIR__.'/temp');
$loader->register();

// start the app
Engine::Run();
