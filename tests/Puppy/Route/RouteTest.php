<?php
namespace Puppy\Route;

use Pimple\Container;

/**
 * Class RouteTest
 * @package Puppy\Puppy\Route
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class RouteTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function testGetPattern(){
        $pattern = 'pattern';
        $controller = function(){};

        $route = new Route($pattern, $controller);
        $this->assertSame($pattern, $route->getPattern());
    }

    /**
     *
     */
    public function testGetController(){
        $pattern = 'pattern';
        $controller = function(){};

        $route = new Route($pattern, $controller);
        $this->assertSame($controller, $route->getController());
    }

    /**
     *
     */
    public function testGetMatchesEmpty(){
        $pattern = 'pattern';
        $controller = function(){};

        $route = new Route($pattern, $controller);
        $this->assertSame(array(), $route->getMatches());
    }

    /**
     *
     */
    public function testGetMatchesSetted(){
        $pattern = 'pattern';
        $controller = function(){};
        $matches = array(1, 2, 3);

        $route = new Route($pattern, $controller);
        $route->setMatches($matches);
        $this->assertSame($matches, $route->getMatches());
    }

    /**
     *
     */
    public function testCall(){
        $pattern = 'pattern';
        $controller = function(){
            return func_get_args();
        };
        $matches = array(1,2,3);
        $services = new Container();

        $route = new Route($pattern, $controller);
        $route->setMatches($matches);
        $this->assertSame(array($matches, $services), $route->call($services));
    }
}
 