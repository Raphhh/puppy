<?php
namespace Puppy;

use Puppy\Tester\Client;

/**
 * Class DemoModuleTest
 * @package Puppy
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class DemoModuleTest extends \PHPUnit_Framework_TestCase
{

    public function testHomePage()
    {
        $client = new Client();
        $this->expectOutputRegex('/Good dog!/');
        $client->run('/');
    }

    public function testContact()
    {
        $client = new Client();
        $this->expectOutputRegex('/Fill the form/');
        $client->run('/contact');
    }

    public function testContactWithEmptyPostedForm()
    {
        $client = new Client();
        $this->expectOutputRegex('/Form not filled/');
        $client->run('/contact', 'POST');
    }

    public function testContactWithPostedForm()
    {
        $client = new Client();
        $this->expectOutputRegex('/Redirecting to \/contact/');
        $application = $client->run('/contact', 'POST', ['email' => 'value']);
        $session = $application->getService('session');
        $this->assertSame('Email sent from value', $session->getFlashBag()->get('text-info')[0]);
    }
}
