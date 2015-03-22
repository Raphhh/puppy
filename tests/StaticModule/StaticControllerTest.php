<?php
namespace StaticModule;

use Puppy\StaticModule\StaticController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

/**
 * Class StaticControllerTest
 * @package StaticModule
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class StaticControllerTest extends \PHPUnit_Framework_TestCase
{

    public function testRender()
    {
        $vars = [];

        $request = new Request();

        $templateRouter = $this->getMockBuilder('Puppy\StaticModule\TemplateRouter')
            ->disableOriginalConstructor()
            ->getMock();

        $templateRouter->expects($this->once())
            ->method('findTemplateFile')
            ->with($request)
            ->will($this->returnValue('template-file-path'));

        $appController = $this->getMockBuilder('Puppy\Controller\AppController')
        ->disableOriginalConstructor()
        ->getMock();

        $appController->expects($this->once())
            ->method('render')
            ->with('template-file-path', $vars)
            ->will($this->returnValue('response'));

        $staticController = new StaticController($request, $templateRouter, $appController);
        $this->assertSame('response', $staticController->render($vars));
    }

    public function testRenderWithoutFile()
    {
        $vars = [];

        $request = new Request();

        $templateRouter = $this->getMockBuilder('Puppy\StaticModule\TemplateRouter')
            ->disableOriginalConstructor()
            ->getMock();

        $templateRouter->expects($this->once())
            ->method('findTemplateFile')
            ->with($request)
            ->will($this->returnValue(''));

        $appController = $this->getMockBuilder('Puppy\Controller\AppController')
            ->disableOriginalConstructor()
            ->getMock();

        $appController->expects($this->once())
            ->method('error404')
            ->will($this->returnValue('404'));

        $staticController = new StaticController($request, $templateRouter, $appController);
        $this->assertSame('404', $staticController->render($vars));
    }

    public function testRedirect()
    {
        $vars = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];

        $request = new Request();
        $request->server->set('REQUEST_URI', 'request-uri');

        $flash = new FlashBag();

        $templateRouter = $this->getMockBuilder('Puppy\StaticModule\TemplateRouter')
            ->disableOriginalConstructor()
            ->getMock();

        $appController = $this->getMockBuilder('Puppy\Controller\AppController')
            ->disableOriginalConstructor()
            ->getMock();

        $appController->expects($this->once())
            ->method('redirect')
            ->with('request-uri')
            ->will($this->returnValue('redirect'));

        $appController->expects($this->exactly(2))
            ->method('flash')
            ->will($this->returnValue($flash));

        $staticController = new StaticController($request, $templateRouter, $appController);
        $this->assertSame('redirect', $staticController->redirect($vars));

        $this->assertSame('value1', $flash->get('key1')[0]);
        $this->assertSame('value2', $flash->get('key2')[0]);

    }

    public function testInvoke()
    {
        $vars = [];

        $request = new Request();

        $templateRouter = $this->getMockBuilder('Puppy\StaticModule\TemplateRouter')
            ->disableOriginalConstructor()
            ->getMock();

        $templateRouter->expects($this->once())
            ->method('findTemplateFile')
            ->with($request)
            ->will($this->returnValue('template-file-path'));

        $appController = $this->getMockBuilder('Puppy\Controller\AppController')
            ->disableOriginalConstructor()
            ->getMock();

        $appController->expects($this->once())
            ->method('render')
            ->with('template-file-path', $vars)
            ->will($this->returnValue('response'));

        $staticController = new StaticController($request, $templateRouter, $appController);
        $this->assertSame('response', $staticController($vars));
    }
}
