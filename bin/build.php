<?php
use Puppy\Config\Config;

chdir(dirname(__DIR__));

require_once 'vendor/autoload.php';

$config = new Config(isset($argv[1]) ? $argv[1] : '');

echo "\nStarting to build\n";

//remove the cache
if ($config['cache.path']) {
    echo " - removing the cache\n";
    exec('rm -fr "' . getcwd() . DIRECTORY_SEPARATOR . $config['cache.path'] . '"');
}
