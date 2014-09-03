<?php
namespace Puppy;

use Pimple\Container;
use Puppy\Route\Route;
use Puppy\Route\RouteFinder;
use Puppy\Route\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class FrontController
 * Controls the app controllers.
 *
 * @package Puppy
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class FrontController
{

    /**
     * @var Container
     */
    private $services;

    /**
     * Constructor.
     *
     * @param Request $request
     * @param Container $services
     */
    public function __construct(Request $request, Container $services = null ) {
        $this->setContainer($services ? : new Container());

        $this->addService(
            'request',
            function () use ($request) {
                return $request;
            }
        );

        $this->addService(
            'router',
            function () {
                return new Router(new RouteFinder());
            }
        );
    }

    /**
     * Adds a service to the services container.
     *
     * @param string $name
     * @param callable $callback
     */
    public function addService($name, callable $callback)
    {
        $this->getContainer()->offsetSet($name, $callback);
    }

    /**
     * Adds a controller to the list of observed controllers.
     *
     * @param string $pattern
     * @param callable $controller
     */
    public function addController($pattern, $controller)
    {
        $this->getService('router')->addRoute(
            new Route($pattern,
                $controller)
        );
    }

    /**
     * Calls the controller matched with the request uri.
     *
     * @return mixed
     */
    public function call()
    {
        return $this->getService('router')
            ->find($this->getService('request')->getRequestUri())
            ->call($this->getContainer());
    }

    /**
     * @param string $name
     * @return mixed
     */
    private function getService($name)
    {
        return $this->getContainer()->offsetGet($name);
    }

    /**
     * @param Container $services
     */
    private function setContainer(Container $services)
    {
        $this->services = $services;
    }

    /**
     * @return Container
     */
    private function getContainer()
    {
        return $this->services;
    }
}
 