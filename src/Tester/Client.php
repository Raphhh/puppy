<?php
namespace Puppy\Tester;

use Puppy\Application;
use Puppy\Config\Config;
use Puppy\Module\ModuleFactory;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Client
 * @package Tester
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class Client 
{
    /**
     * @param $requestUri
     * @param string $method
     * @param array $post
     * @return Application
     */
    public function run($requestUri, $method='GET', array $post = [])
    {
        $_SERVER['REQUEST_URI'] = $requestUri;
        $_SERVER['REQUEST_METHOD'] = $method;
        $_POST = $post;

        chdir(dirname(dirname(__DIR__)));

        $puppy = new Application(new Config('test'), Request::createFromGlobals());
        $puppy->initModules((new ModuleFactory())->createFromApplication($puppy));
        $puppy->run();

        unset($_SERVER['REQUEST_URI']);
        unset($_SERVER['REQUEST_METHOD']);
        $_POST = [];

        return $puppy;
    }
}
