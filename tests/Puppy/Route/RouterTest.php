<?php
namespace Puppy\Route;

/**
 * Class RouterTest
 * @package Puppy\Route
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class RouterTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function testFind(){
        $finderResult = 'finder_result';
        $uri = 'uri';
        $route = new Route('pattern', function(){});

        $router = new Router($this->getRouteFinder($finderResult, $uri, $route));
        $router->addRoute($route);
        $this->assertSame($finderResult, $router->find($uri));
    }

    /**
     * @param mixed $finderResult
     * @param string $uri
     * @param Route $route
     * @return RouteFinder
     */
    private function getRouteFinder($finderResult, $uri, Route $route)
    {
        $routeFinder = $this->getMock('Puppy\Route\RouteFinder');

        $routeFinder->expects($this->any())
            ->method('find')
            ->will($this->returnValue($finderResult));

        $routeFinder->expects($this->once())
            ->method('find')
            ->with($uri, array($route));

        return $routeFinder;
    }
}
 