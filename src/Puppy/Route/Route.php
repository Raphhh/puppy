<?php
namespace Puppy\Route;

use Pimple\Container;

/**
 * Class Route
 * maps a pattern of uri with a controller
 * @package Puppy\Route
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class Route
{
    /**
     * @var string
     */
    private $pattern;

    /**
     * @var callable
     */
    private $controller;

    /**
     * @var array
     */
    private $matches = array();

    /**
     * Constructor
     *
     * @param string $pattern
     * @param callable $controller
     */
    public function __construct($pattern, callable $controller)
    {
        $this->setPattern($pattern);
        $this->setController($controller);
    }

    /**
     * Calls the controller and give it $matches and $services.
     *
     * @param Container $services
     * @return mixed
     */
    public function call(Container $services)
    {
        return call_user_func_array(
            $this->getController(),
            array($this->getMatches(), $services)
        );
    }

    /**
     * @param array $matches
     */
    public function setMatches(array $matches)
    {
        $this->matches = $matches;
    }

    /**
     * @return array
     */
    public function getMatches()
    {
        return $this->matches;
    }

    /**
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * @return callable
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param callable $controller
     */
    private function setController(callable $controller)
    {
        $this->controller = $controller;
    }

    /**
     * @param string $pattern
     */
    private function setPattern($pattern)
    {
        $this->pattern = (string)$pattern;
    }


}