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
     * @var string
     */
    private $env;

    /**
     * @param string $env
     */
    public function __construct($env='test')
    {
        $this->setEnv($env);
    }

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

        $cwd = getcwd();
        chdir(dirname(dirname(__DIR__)));

        $puppy = new Application(new Config($this->getEnv()), Request::createFromGlobals());
        $puppy->initModules((new ModuleFactory())->createFromApplication($puppy));
        $puppy->run();

        unset($_SERVER['REQUEST_URI']);
        unset($_SERVER['REQUEST_METHOD']);
        $_POST = [];

        chdir($cwd);

        return $puppy;
    }

    /**
     * Getter of $env
     *
     * @return string
     */
    public function getEnv()
    {
        return $this->env;
    }

    /**
     * Setter of $env
     *
     * @param string $env
     */
    public function setEnv($env)
    {
        $this->env = (string)$env;
    }
}
