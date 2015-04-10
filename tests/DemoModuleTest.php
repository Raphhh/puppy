<?php
namespace Puppy;

use Puppy\Client\Client;

/**
 * Class DemoModuleTest
 * @package Puppy
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class DemoModuleTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @medium
     */
    public function testHomePage()
    {
        $client = new Client('test', dirname(__DIR__));
        $this->expectOutputRegex('/Good dog!/');
        $client->run('/');
    }

    /**
     * @medium
     */
    public function testContact()
    {
        $client = new Client('test', dirname(__DIR__));
        $this->expectOutputRegex('/Fill the form/');
        $client->run('/contact');
    }

    /**
     * @medium
     */
    public function testContactWithEmptyPostedForm()
    {
        $client = new Client('test', dirname(__DIR__));
        $this->expectOutputRegex('/Form not filled/');
        $client->run('/contact', 'POST');
    }

    /**
     * @medium
     */
    public function testContactWithPostedForm()
    {
        $client = new Client('test', dirname(__DIR__));
        $this->expectOutputRegex('/Redirecting to \/contact/');
        $application = $client->run('/contact', 'POST', ['email' => 'value']);
        $session = $application->getService('session');
        $this->assertSame('Email sent from value', $session->getFlashBag()->get('text-info')[0]);
    }
}
