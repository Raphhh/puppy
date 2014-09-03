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
     *  Tests that the controller can retrieve the args if asked
     */
    public function testCall(){
        $pattern = 'pattern';
        $controller = function(array $matches, Container $services){
            return func_get_args();
        };
        $matches = array(1,2,3);
        $services = new Container();

        $route = new Route($pattern, $controller);
        $route->setMatches($matches);
        $this->assertSame(array($matches, $services), $route->call($services));
    }

    /**
     * Tests that no args is given to the controller, if the controller asked for no args
     */
    public function testCallArgsEmpty(){
        $pattern = 'pattern';
        $controller = function(){
            return func_get_args();
        };
        $matches = array(1,2,3);
        $services = new Container();

        $route = new Route($pattern, $controller);
        $route->setMatches($matches);
        $this->assertSame(array(), $route->call($services));
    }

    /**
     * Tests we can retrieve a specific service in the params of the controller
     */
    public function testCallWithServices(){
        $pattern = 'pattern';
        $controller = function(\stdClass $service1){
            return func_get_args();
        };
        $matches = array(1,2,3);

        $services = new Container();
        $services['service1'] = function(){
            return new \stdClass();
        };

        $route = new Route($pattern, $controller);
        $route->setMatches($matches);
        $this->assertSame(array($services['service1']), $route->call($services));
    }


    /**
     * Tests that the services not asked are not instantiated
     */
    public function testCallWithServicesNotCalled(){
        $pattern = 'pattern';
        $controller = function(){
            return func_get_args();
        };

        $call = 0;

        $services = new Container();
        $services['service1'] = function() use(&$call){
            return ++$call;
        };

        $route = new Route($pattern, $controller);
        $route->call($services);
        $this->assertSame(1, $services['service1']); ///service1 is called for the first time
    }
}
 