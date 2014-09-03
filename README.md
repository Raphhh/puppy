# Puppy

[![Latest Stable Version](https://poser.pugx.org/raphhh/puppy/v/stable.svg)](https://packagist.org/packages/raphhh/puppy)
[![Build Status](https://travis-ci.org/Raphhh/puppy.png)](https://travis-ci.org/Raphhh/puppy)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/Raphhh/puppy/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Raphhh/puppy/)
[![Code Coverage](https://scrutinizer-ci.com/g/Raphhh/puppy/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Raphhh/puppy/)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/_/mini.png)](https://insight.sensiolabs.com/projects/_)
[![Dependency Status](https://www.versioneye.com/user/projects/54062eb9c4c187ff6100006f/badge.svg?style=flat)](https://www.versioneye.com/user/projects/54062eb9c4c187ff6100006f)
[![Total Downloads](https://poser.pugx.org/raphhh/puppy/downloads.svg)](https://packagist.org/packages/raphhh/puppy)
[![Reference Status](https://www.versioneye.com/php/raphhh:puppy/reference_badge.svg?style=flat)](https://www.versioneye.com/php/raphhh:puppy/references)
[![License](https://poser.pugx.org/raphhh/puppy/license.svg)](https://packagist.org/packages/raphhh/puppy)

A tiny, brave and faithful MVC‏ framework

## Installation

```
$ composer create-project raphhh/puppy path/to/my/project
```

## Add controllers

Edit the file public/index.php and add controllers with the method FrontController::addController(string $pattern, callable $controller).

### What is a controller?

A controller is any callable.

For example, callable can be a closure:

```php
$frontController->addController('#(.*?)#', function(){
        return '<h1>Hello world!</h1>';
    });
```

or can be a class method:

```php
$frontController->addController('#(.*?)#', array($controller, 'method'));
```

### What is a controller pattern?

A pattern of a controller is a regex which will match with a specific request uri.

Only one of your controllers will be called when its pattern will match with the request uri. So, depending of the uri, the code of your controller will be executed.

Your controller will return the response to send to the client. This can be a simple string. But more powerful, this can be also a Response, which will manage also the http header.

```php
$frontController->addController('#(.*?)#', function(){
         return new Response('<h1>Hello world!</h1>');
    });
```

## Add services

Edit the file public/index.php and add services with the method FrontController::addServices(string $name, Container $service).

### What is a service?

A service is a class which will be present in all your controllers.

by default, Puppy add two services:
 * request
 * router

You can add any service you want, like for example a templating library.

## What arguments will receive the controller?

The controller receive two kind of argument, depending what you want.

#### The matches patterns

If you want to receive the list of matches between pattern and uri, you must specify the param "array $matches".

```php
$frontController->addController('#hello/(.*?)#', function(array $matches){
        return $matches[1]; //will return the value "world" for the uri "/hello/world"
    });
```

#### The Services

If you want to have the services container, you must specify the param "Container $services".

```php
$frontController->addController('#hello/(.*?)#', function(Container $services){
        ...
    });
```

Of course, you can have the services with the matches.

```php
$frontController->addController('#hello/(.*?)#', function(array $matches, Container $services){
        ...
    });
```
The order of params has no importance!

You can also specify which service you want. you just have to name it in the params.

```php
$frontController->addController('#(.*?)#', function(Request $request){
        return '<h1>Hello world!</h1> <p>You ask for the uri "'.htmlentities($request->getRequestUri()).'"</p>';
    });
```
