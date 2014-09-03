<?php
namespace Puppy\Route;

use DomainException;

/**
 * Class RouteFinderµ
 * Finds a route in matching its pattern with a uri.
 *
 * @package Puppy\Route
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class RouteFinder
{
    /**
     * Finds a route in matching its pattern with a uri.
     *
     * @param string $uri
     * @param Route[] $routes
     * @throws DomainException
     * @return Route
     */
    public function find($uri, array $routes)
    {
        foreach ($routes as $route) {
            $routeMatches = $this->match($uri, $route->getPattern());
            if ($routeMatches) {
                $route->setMatches($routeMatches);
                return $route;
            }
        }
        throw new DomainException(sprintf(
            'No route found for uri "%s"',
            $uri
        ));
    }

    /**
     * @param string $uri
     * @param string $pattern
     * @return string[]
     */
    private function match($uri, $pattern)
    {
        $matches = array();
        @preg_match($pattern, $uri, $matches); //todo catch the warning to an exception
        return $matches;
    }
}
 