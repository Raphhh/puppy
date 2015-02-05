<?php
namespace Puppy\StaticModule;

use Puppy\Application;
use Puppy\Config\Config;
use Puppy\Controller\AppController;
use Puppy\Module\IModule;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class StaticModule
 * @package Puppy
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class StaticModule implements IModule
{

    /**
     * init the module.
     *
     * @param Application $application
     */
    public function init(Application $application)
    {
        $application->addService(
            'templateRouter',
            function (\ArrayAccess $services) {
                return new TemplateRouter($services['config']);
            }
        );

        $application->any(
            ':all',
            function (TemplateRouter $templateRouter, Request $request) {
                /**
                 * @var AppController $this
                 */
                $templateFile = $templateRouter->findTemplateFile($request);
                if ($templateFile) {
                    return $this->render($templateFile);
                }
                return $this->error404();
            }
        );
    }
}
 