<?php
namespace Puppy\StaticModule;

/**
 * Class StaticControllerService
 * @package StaticModule
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class StaticControllerService
{
    /**
     * @param \ArrayAccess $services
     * @return StaticController
     */
    public function __invoke(\ArrayAccess $services)
    {
        return new StaticController(
            $services['request'],
            new TemplateRouter($services['config']),
            $services['appController']
        );
    }
}
