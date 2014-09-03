<?php
namespace Puppy\Route;

use Pimple\Container;
use TRex\Reflection\CallableReflection;

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
        $callbackReflection = new CallableReflection($this->getController());
        return $callbackReflection->invokeA($this->prepareArgs($services, $callbackReflection));
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

    /**
     * @param Container $services
     * @param CallableReflection $callbackReflection
     * @return array
     */
    private function prepareArgs(Container $services, CallableReflection $callbackReflection)
    {
        $args = array(
            'matches' => $this->getMatches(),
            'services' => $services,
        );
        foreach ($services->keys() as $key) {
            foreach ($callbackReflection->getReflector()->getParameters() as $reflectionParameter) {
                if ($reflectionParameter->getName() === $key) {
                    $args[$key] = $services[$key];
                }
            }
        }
        return $args;
    }


}