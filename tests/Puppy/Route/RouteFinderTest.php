<?php
namespace Puppy\Route;

/**
 * Class RouteFinderTest
 * @package Puppy\Route
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class RouteFinderTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function testFind(){
        $routes = array(
            new Route('#this/one#', function(){}),
            new Route('#this/other#', function(){}),
        );

        $routeFinder = new RouteFinder();
        $this->assertSame('#this/one#', $routeFinder->find('this/one',$routes)->getPattern());
    }

    /**
     *
     */
    public function testFindWithException(){
        $routeFinder = new RouteFinder();

        $this->setExpectedException('DomainException', 'No route found for uri "this/one"');
        $routeFinder->find('this/one', array());
    }
}
 