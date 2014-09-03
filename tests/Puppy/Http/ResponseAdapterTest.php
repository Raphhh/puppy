<?php
namespace Puppy\Http;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class ResponseAdapterTest
 * @package Puppy\Http
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class ResponseAdapterTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function testSendWithString()
    {

        $responseAdapter = new ResponseAdapter('content');
        ob_start();
        $responseAdapter->send();
        $adapterResult = ob_get_clean();

        $response = new Response('content');
        ob_start();
        $response->send();
        $responseResult = ob_get_clean();

        $this->assertSame($responseResult, $adapterResult);
    }

    /**
     *
     */
    public function testSendWithResponse()
    {

        $responseAdapter = new ResponseAdapter(new Response('content'));
        ob_start();
        $responseAdapter->send();
        $adapterResult = ob_get_clean();

        $response = new Response('content');
        ob_start();
        $response->send();
        $responseResult = ob_get_clean();

        $this->assertSame($responseResult, $adapterResult);
    }
}
 