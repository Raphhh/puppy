<?php
namespace Puppy;

use Puppy\Module\IModule;
use Puppy\Service\Session;
use Puppy\Service\Template;

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
        $application->addService('template', new Template());
        $application->addService('session', new Session());
    }
}
 