<?php
namespace Puppy;

use Pimple\Container;
use Puppy\Route\Route;
use Puppy\Route\Router;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FrontControllerTest
 * @package Puppy
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class FrontControllerTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function testAddService(){
        $request = new Request();
        $services = new Container();

        $frontController = new FrontController($request, $services);
        $frontController->addService('service1', function(){ return 'value1'; });
        $this->assertSame('value1', $services['service1']);
    }

    /**
     *
     */
    public function testAddController(){
        $controller = function(){ };
        $request = new Request();
        $services = new Container();

        $frontController = new FrontController($request, $services);
        $frontController->addController('pattern', $controller);
        $this->assertRouter($services['router'], $controller);
    }

    /**
     * @param Router $router
     * @param callable $controller
     */
    private function assertRouter(Router $router, callable $controller){
        $routes = $router->getRoutes();
        $this->assertArrayHasKey('pattern', $routes);
        $this->assertSame($controller, $routes['pattern']->getController());
    }

    /**
     *
     */
    public function testAddCall(){
        $request = new Request();
        $services = new Container();
        $router = $this->getRouter($request, $services);

        $frontController = new FrontController($request, $services);
        $frontController->addService('router', function() use($router){ return $router; });
        $this->assertSame('route_call_result', $frontController->call());
    }

    /**
     * @param Request $request
     * @param Container $services
     * @return Router
     */
    private function getRouter(Request $request, Container $services)
    {
        $router = $this->getMockBuilder('Puppy\Route\Router')
            ->disableOriginalConstructor()
            ->getMock();

        $router->expects($this->any())
            ->method('find')
            ->will($this->returnValue($this->getRoute($services)));

        $router->expects($this->once())
            ->method('find')
            ->with($request->getRequestUri());

        return $router;
    }

    /**
     * @param \Pimple\Container $services
     * @return Route
     */
    private function getRoute(Container $services)
    {
        $route = $this->getMockBuilder('Puppy\Route\Route')
            ->disableOriginalConstructor()
            ->getMock();

        $route->expects($this->any())
            ->method('call')
            ->will($this->returnValue('route_call_result'));

        $route->expects($this->once())
            ->method('call')
            ->with($services);

        return $route;
    }
}
 