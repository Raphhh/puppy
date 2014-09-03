<?php
namespace Puppy\Http;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class Response
 * Allows to use string or Response
 *
 * @package Puppy\Http
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class ResponseAdapter implements IResponse
{

    /**
     * @var mixed
     */
    private $content;

    /**
     * @param mixed $content
     */
    public function __construct($content)
    {
        $this->setContent($content);
    }

    /**
     * Sends the http response
     */
    public function send()
    {
        if ($this->getContent() instanceof Response) {
            $this->getContent()->send();
        } else {
            $response = new Response($this->getContent());
            $response->send();
        }
    }

    /**
     * Setter of $content
     *
     * @param mixed $content
     */
    private function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Getter of $content
     *
     * @return mixed
     */
    private function getContent()
    {
        return $this->content;
    }
}
 