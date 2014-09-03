<?php
namespace Puppy;

use ArrayAccess;
use Pimple\Container;
use Puppy\Route\Route;
use Puppy\Route\RouteFinder;
use Puppy\Route\Router;
use Symfony\Component\HttpFoundation\Request;

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
     * @var ArrayAccess
     */
    private $services;

    /**
     * Constructor.
     *
     * @param Request $request
     * @param ArrayAccess $services
     */
    public function __construct(Request $request, ArrayAccess $services = null)
    {
        $this->setServices($services ? : new Container());

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
        $this->getServices()->offsetSet($name, $callback);
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
            ->call($this->getServices());
    }

    /**
     * @param string $name
     * @return mixed
     */
    private function getService($name)
    {
        return $this->getServices()->offsetGet($name);
    }

    /**
     * @param ArrayAccess $services
     */
    private function setServices(ArrayAccess $services)
    {
        $this->services = $services;
    }

    /**
     * @return ArrayAccess
     */
    private function getServices()
    {
        return $this->services;
    }
}
 