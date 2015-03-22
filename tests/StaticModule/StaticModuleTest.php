<?php
namespace StaticModule;

use Puppy\Application;
use Puppy\MainModule;
use Puppy\StaticModule\StaticModule;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class StaticModuleTest
 * @package StaticModule
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class StaticModuleTest extends \PHPUnit_Framework_TestCase
{

    public function testInitForHomeUrl()
    {
        $config = new \ArrayObject();
        $config['template.directory.main'] = __DIR__ . '/resources/templates';
        $config['template.directory.cache'] = __DIR__ . '/resources/cache';
        $config['session.sessionStorageClass'] = 'Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage';

        $application = new Application($config, new Request());

        $mainModule = new MainModule();
        $mainModule->init($application);

        $staticModule = new StaticModule();
        $staticModule->init($application);

        $this->expectOutputString('Hello world!');
        $application->run();
    }

    public function testInitForBarUrl()
    {
        $config = new \ArrayObject();
        $config['template.directory.main'] = __DIR__ . '/resources/templates';
        $config['template.directory.cache'] = __DIR__ . '/resources/cache';
        $config['session.sessionStorageClass'] = 'Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage';

        $request = new Request();
        $request->server->set('REQUEST_URI', 'bar');

        $application = new Application($config, $request);

        $mainModule = new MainModule();
        $mainModule->init($application);

        $staticModule = new StaticModule();
        $staticModule->init($application);

        $this->expectOutputString('bar');
        $application->run();
    }
}
