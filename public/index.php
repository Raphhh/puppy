<?php
use Pimple\Container;
use Puppy\FrontController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once '../vendor/autoload.php';

$frontController = new FrontController(Request::createFromGlobals(), new Container());


//example /hello/<yourName>
$frontController->addController('#/hello/(.*?)$#', function(array $matches){
        return '<h1>Hello '.htmlentities($matches[1]).'!</h1>';
    });

//default controller
$frontController->addController('#(.*?)#', function(Request $request){
        return new Response('<h1>Hello world!</h1> <p>You ask for the uri "'.htmlentities($request->getRequestUri()).'"</p>');
    });


//execute
echo $frontController->call();
