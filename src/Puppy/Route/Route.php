<?php
namespace Puppy\Route;

use ArrayAccess;
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
     * @var string[]
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
     * @param ArrayAccess $services
     * @return mixed
     */
    public function call(ArrayAccess $services)
    {
        $callbackReflection = new CallableReflection($this->getController());
        return $callbackReflection->invokeA($this->prepareArgs($services, $callbackReflection));
    }

    /**
     * @param string[] $matches
     */
    public function setMatches(array $matches)
    {
        $this->matches = $matches;
    }

    /**
     * @return string[]
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
     * @param ArrayAccess $services
     * @param CallableReflection $callbackReflection
     * @return array
     */
    private function prepareArgs(ArrayAccess $services, CallableReflection $callbackReflection)
    {
        $args = array(
            'matches' => $this->getMatches(),
            'services' => $services,
        );

        foreach ($callbackReflection->getReflector()->getParameters() as $reflectionParameter) {
            if ($services->offsetExists($reflectionParameter->getName())) {
                $args[$reflectionParameter->getName()] = $services[$reflectionParameter->getName()];
            }
        }

        return $args;
    }


}