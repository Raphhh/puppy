<?php
namespace Puppy\StaticModule;

use Puppy\Service\resources\RequestMock;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TemplateRouterTest
 * @package Puppy\Service
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class TemplateRouterTest extends \PHPUnit_Framework_TestCase
{
    private $cwd;

    public function setUp()
    {
        $this->cwd = getcwd();
        chdir(__DIR__ . '/resources');
    }

    public function tearDown()
    {
        chdir($this->cwd);
    }

    public function test__invokeWithoutConfigForDirectoryMain()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            'Config must define the key "template.directory.main" for the path to the template files'
        );
        new TemplateRouter(new \ArrayObject([]));
    }

    public function test__invokeWithEmptyRequest()
    {
        $template = new TemplateRouter(
            new \ArrayObject(
                [
                    'template.directory.main' => 'templates',
                ]
            )
        );

        $result = $template->findTemplateFile(new Request());
        $this->assertSame(
            'public' . DIRECTORY_SEPARATOR . 'index.html.twig',
            $result
        );
    }

    public function test__invokeWithSlashRequest()
    {
        $request = new RequestMock();
        $request->setRequestUri('/');

        $template = new TemplateRouter(
            new \ArrayObject(
                [
                    'template.directory.main' => 'templates',
                ]
            )
        );

        $result = $template->findTemplateFile($request);
        $this->assertSame(
            'public' . DIRECTORY_SEPARATOR . 'index.html.twig',
            $result
        );
    }

    public function test__invokeWithExistingFile()
    {
        $request = new RequestMock();
        $request->setRequestUri('index.html');

        $template = new TemplateRouter(
            new \ArrayObject(
                [
                    'template.directory.main' => 'templates',
                ]
            )
        );

        $result = $template->findTemplateFile($request);
        $this->assertSame(
            'public' . DIRECTORY_SEPARATOR . 'index.html.twig',
            $result
        );
    }

    public function test__invokeWithExistingFileWithSlash()
    {
        $request = new RequestMock();
        $request->setRequestUri('/index.html');

        $template = new TemplateRouter(
            new \ArrayObject(
                [
                    'template.directory.main' => 'templates',
                ]
            )
        );

        $result = $template->findTemplateFile($request);
        $this->assertSame(
            'public' . DIRECTORY_SEPARATOR . 'index.html.twig',
            $result
        );
    }

    public function test__invokeWithoutExistingFile()
    {
        $request = new RequestMock();
        $request->setRequestUri('none');

        $template = new TemplateRouter(
            new \ArrayObject(
                [
                    'template.directory.main' => 'templates',
                ]
            )
        );

        $result = $template->findTemplateFile($request);
        $this->assertSame(
            '',
            $result
        );
    }

    public function test__invokeForSubDirectory()
    {
        $request = new RequestMock();
        $request->setRequestUri('bar');

        $template = new TemplateRouter(
            new \ArrayObject(
                [
                    'template.directory.main' => 'templates',
                ]
            )
        );

        $result = $template->findTemplateFile($request);
        $this->assertSame(
            'public' . DIRECTORY_SEPARATOR . 'bar' . DIRECTORY_SEPARATOR . 'index.html.twig',
            $result
        );
    }

    public function test__invokeForNotExistingDirectory()
    {
        $request = new RequestMock();
        $request->setRequestUri('foo');

        $template = new TemplateRouter(
            new \ArrayObject(
                [
                    'template.directory.main' => 'templates',
                ]
            )
        );

        $result = $template->findTemplateFile($request);
        $this->assertSame(
            '',
            $result
        );
    }

    public function test__invokeForSlash()
    {
        $request = new RequestMock();
        $request->setRequestUri('/');

        $template = new TemplateRouter(
            new \ArrayObject(
                [
                    'template.directory.main' => 'templates',
                ]
            )
        );

        $result = $template->findTemplateFile($request);
        $this->assertSame(
            'public' . DIRECTORY_SEPARATOR . 'index.html.twig',
            $result
        );
    }

    public function test__invokeForSlashinSubDirectory()
    {
        $request = new RequestMock();
        $request->setRequestUri('/bar/');

        $template = new TemplateRouter(
            new \ArrayObject(
                [
                    'template.directory.main' => 'templates',
                ]
            )
        );

        $result = $template->findTemplateFile($request);
        $this->assertSame(
            'public' . DIRECTORY_SEPARATOR . 'bar' . DIRECTORY_SEPARATOR . 'index.html.twig',
            $result
        );
    }
}
 