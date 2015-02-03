<?php
use Puppy\Application;
use Puppy\Config\Config;
use Puppy\Module\ModuleFactory;
use Symfony\Component\HttpFoundation\Request;

require_once '../vendor/autoload.php';

/**
 * Puppy runs for you with happiness!
 *
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 * @doc https://github.com/Raphhh/puppy
 */

chdir(dirname(__DIR__));

$puppy = new Application(new Config(getenv('APPLICATION_ENV')), Request::createFromGlobals());
$puppy->initModules((new ModuleFactory())->createFromApplication($puppy));
$puppy->run(); //good dog! :)
