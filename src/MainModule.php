<?php
namespace Puppy;

use Puppy\Module\IModule;
use Puppy\Service\Session;
use Puppy\Service\Template;
use Puppy\Service\Twig\TwigExtension;

/**
 * Class MainModule
 * add basic puppy services
 *
 * @package Puppy
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class MainModule implements IModule
{
    /**
     * init the module.
     *
     * @param Application $application
     */
    public function init(Application $application)
    {
        $application->addService('template', new Template([
            new TwigExtension($application->getServices()),
        ]));
        $application->addService('session', new Session());
    }
}
 