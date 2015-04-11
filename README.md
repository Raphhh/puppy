# Puppy framework

[![Latest Stable Version](https://poser.pugx.org/raphhh/puppy/v/stable.svg)](https://packagist.org/packages/raphhh/puppy)
[![Build Status](https://travis-ci.org/Raphhh/puppy.png)](https://travis-ci.org/Raphhh/puppy)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/Raphhh/puppy/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Raphhh/puppy/)
[![Code Coverage](https://scrutinizer-ci.com/g/Raphhh/puppy/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Raphhh/puppy/)
[![Total Downloads](https://poser.pugx.org/raphhh/puppy/downloads.svg)](https://packagist.org/packages/raphhh/puppy)
[![License](https://poser.pugx.org/raphhh/puppy/license.svg)](https://packagist.org/packages/raphhh/puppy)

Puppy is a micro-framework built in PHP that helps you to create websites using [Twig](http://twig.sensiolabs.org/) templates!

With Puppy, you will be able to build websites directly in Twig, without any problems of routes nor configuration. Puppy is ready-to-use: you just have to implement your html code.

Puppy uses a simple route system which you can easily extend to add your own behaviour and get more interactivity. For example, you can create a form which will be handled in back-end with Puppy.


## Resources

### Website
[http://www.puppyframework.com/](http://www.puppyframework.com/)

### Code
#### Core
- [puppy-application](https://github.com/Raphhh/puppy-application)
- [puppy-config](https://github.com/Raphhh/puppy-config)

#### Modules
- [puppy-template](https://github.com/Raphhh/puppy-template)
- [puppy-session](https://github.com/Raphhh/puppy-session)
- [puppy-static-route](https://github.com/Raphhh/puppy-static-route)

#### Testing
 - [puppy-client](https://github.com/Raphhh/puppy-client)

## About

Puppy is a skeleton that runs Puppy\Application. It uses Puppy\Config as config manager.

It includes some default modules:
 - [Template module](https://github.com/Raphhh/puppy-template) allows to use Twig as template engine.
 - [Static routing module](https://github.com/Raphhh/puppy-static-route) allows to route request uri directly to a template.
 - [Session module](https://github.com/Raphhh/puppy-session) helps to manage the session.


## Installation

Use [Composer](http://getcomposer.org/) to download Puppy:

```console
$ composer create-project raphhh/puppy path/to/my/project
```


## Files architecture

    ├── bin
    |   ├── build
    |   └── run
    ├── config
    |   ├── dev.php
    |   ├── global.php
    |   └── tets.php
    ├── public
    |   ├── .htaccess
    |   ├── index.php
    |   └── robots.txt
    ├── src
    ├── templates
    |   └── public
    |       └── index.html.twig
    ├── tests
    ├── vars
    ├── vendor
    ├── .editorconfig
    ├── .gitattributes
    ├── .gitignore
    ├── .scrutinizer.yml
    ├── .travis.yml
    ├── composer.json
    ├── composer.lock
    ├── LICENSE
    ├── phpunit.xml.dist
    ├── puppy
    └── README.md

- "bin" contains the executable that you can launch in the console with the command "puppy".
- "config" contains all your config files.
- "public" is the web entry point.
- "src" contains all your PHP code.
- "templates" contains your twig files. It is used by the "static routing" module. 
- "tests" contains all your PHP tests. See [PHPUnit](https://phpunit.de/) for more information.
- "vars" is a tmp folder, containing things like cache, ...
- "vendor" contains all your PHP dependencies. See [Composer](https://getcomposer.org/) for more information.

## Run the demo

### Use the built-in PHP server

Use the run command in your console:

```console
$ puppy run
```

Then, you can launch Puppy in your browser at http://localhost:8080.

You can also specify you want to run the dev env (no cache).

```console
$ puppy run dev
```

### Use any server

First, you have to know that the public http access to Puppy is the dir '/public'. It is where you will put your css or your js.

If Puppy is not located at the root of your url address, create a local config to define the base url. For example, if you will launch Puppy at 'http://localhost/puppy/public', your local config must be:

```php
// config/local.php
<?php
return [
    'baseUrl' => '/puppy/public/', //use only an absolute path
];
```

Local config is not versioned and will never go to production. For more information about config, see specific section. 

See also how to set the dev env variable 'APP_ENV'.

Then, you can launch Puppy in your browser. :) 

### Clean the cache

To clean the cache, rebuild your project:

```console
$ puppy build
```

## Create your own application

Now you want to code your site. 

First, be careful with the cache of Puppy. If Puppy is cached, your modifications will not appear in the screen. See the config section to disable the cache.

Now, let's see how the static routing works. 

### Static routing in a nutshell

The "static routing" is a module that routes an uri to a template file. The router takes the request uri and tries to find an associated template.

Note that the template files must be in the dir "template/public/".

If the request uri points to a dir and not a file, a default file will be searched. By default: "<dir>/index.html.twig".

If no file is found in the templates, it returns an HTTP 404 error.

Note that, because it is a module (raphhh/puppy-static-route), you can remove it. See module section for more information.


### Add new pages

Consider directory '/templates/public' like a mirror of your public site access, but specially dedicated to twig templates. For each page you want in your website, you have to put a twig file in this directory. Name this file as if it was a html file, but complete it with extension '.twig'.

For example, for a home page, normally you will use a 'index.html' at the root of your public area. Here, with Puppy, you have to create a file '/templates/public/index.html.twig'. Same name, but with specific extension.

So, for example, these uri will call those twig:

 - / => templates/public/**index.html.twig**
 - /index.html => templates/public/**index.html.twig**
 - /contact.html => templates/public/**contact.html.twig**
 - /contact => templates/public/**contact/index.html.twig**
 - /contact/index.html => templates/public/**contact/index.html.twig**
 
### Create common private templates

Now, imagine you want to add a second page, like a contact page for example. So, you want to display a new template for the url '/contact.html'. You just have to create this new template in the file '/templates/public/contact.html.twig'.

Once you have created your second template file, there is some duplicated code in your html (header, menu, footer, ...). No problem, here comes Twig! You can, for example, group your common base html code in a separate file that each page will extend.

As this file must not be directly accessible from an url, it must not appear in the '/templates/public' dir. You have to put it directly at the root of the '/templates' dir. So, it will never be called from any url.

### Add some specific behaviours

Now, imagine you have a form in your contact page, sending an email. You can easily add a function to handle your form in php.

First, you have to add a new route to handle the posted form.

```php
$application->post('contact', function(){ 
    ...
});
```

In the controller, you have to test if the form is valid for you. If the form is not valid, you can call the twig template associated with your uri, and give it an error message.

```php
//if the form is not filled, we display the form with the error
return $staticController->render([
    'text-danger' => 'Form not filled'
]);
```

If the form is valid and you have done the job, you can redirect to avoid refresh problems.

```php
//if the email is send, we redirect to avoid F5.
return $staticController->redirect([
    'text-info' => 'Email sent'
]);
```

It is easy to retrieve the message given to the template (with 'render' or 'redirect' method). You just have to use 'retriever' service.

```twig
{% if services['retriever'].has('text-danger') %}
    <p class="text-danger">{{ services['retriever'].get('text-danger') }}</p>
{% endif %}
```

See the DemoModule to have an example.

## Config

Add all the config you want, depending on each environment. Puppy uses an easy config provider. 

Your config is defined in the dir '/config'. 

By default, you have two versioned config (global and dev). 'dev' config is not loaded in prod env. But to specify you are in dev env (and avoid cache), you have to set the env variable 'APP_ENV'.

Moreover, you have a third config (local) which is not versioned. You can specify stuff only for you.

For more information, see [puppy-config](https://github.com/Raphhh/puppy-config) documentation.

## Routes

Add any special routes you want for particular behaviour. Puppy uses a complete route provider. 

```php
$application->get('hello', function(){ 
    return 'Hello world!';
});
```

For more information, see [puppy-application](https://github.com/Raphhh/puppy-application) documentation.

## Services

Add all your services you need. Puppy uses [Pimple](https://github.com/silexphp/Pimple) as service container.

```php
$application->addService('serviceName', function(Container $services){
    return new MyService();
});
```

For more information, see [puppy-application](https://github.com/Raphhh/puppy-application) documentation.

Puppy is built with pre-config services:

 - config: gives you the config of your env.
 - request: gives you the current request ($_REQUEST, ...).
 - template: handles the twig engine.
 - session: handles the session.
 - appController: gives you some nice tools to use in your controllers.
 - staticController: calls the twig template associated with the current uri. 
 - frontController: calls the controller associated with the current request and display the view.
 - router: finds the controller associated with a route.
 - retriever: finds the params given to a page.

For more information about session and template, see [puppy-service](https://github.com/Raphhh/puppy-service) documentation.

## Modules

A module is an external package that you can add to Puppy like a pluggin. A module can add specific services, controllers, config, and so on. See the module documentation for more information.

Adding a new module is very simple in Puppy. You just has to load the package with Composer:
```console
$ composer require <vendor/puppy-module>
```

That's it, it works!

Removing is also simple:
```console
$ composer remove <vendor/puppy-module>
```

Puppy includes some default modules, like the session, the template, and the static routing. But, you can easily replace them.

## HTTP response (todo)

You can manage the header of your HTTP response with the method 'after'. So, for example, you can define the http cache.

```php
$application->after(function(Response $response){
    ...
});
```

## Error (todo)

Puppy handles automatically your errors and exceptions. It logs them into a file and can send you an email.

For error handling, see the [puppy-application](https://github.com/Raphhh/puppy-application) documentation.
 
## Integration and deployment

### How to launch the tests?

See Travis config in .travis.yml.

### How to deploy?

See composer install script in composer.json.
