# Puppy framework

[![Latest Stable Version](https://poser.pugx.org/raphhh/puppy/v/stable.svg)](https://packagist.org/packages/raphhh/puppy)
[![Build Status](https://travis-ci.org/Raphhh/puppy.png)](https://travis-ci.org/Raphhh/puppy)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/Raphhh/puppy/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Raphhh/puppy/)
[![Code Coverage](https://scrutinizer-ci.com/g/Raphhh/puppy/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Raphhh/puppy/)
[![Total Downloads](https://poser.pugx.org/raphhh/puppy/downloads.svg)](https://packagist.org/packages/raphhh/puppy)
[![Reference Status](https://www.versioneye.com/php/raphhh:puppy/reference_badge.svg?style=flat)](https://www.versioneye.com/php/raphhh:puppy/references)
[![License](https://poser.pugx.org/raphhh/puppy/license.svg)](https://packagist.org/packages/raphhh/puppy)

Puppy is a micro-framework built in PHP that helps you to create websites using [Twig templates](http://twig.sensiolabs.org/)!

With Puppy, you will be able to build websites directly in Twig, without any problems of routes nor configuration. Puppy is ready-to-use: you just have to implement your html code.

Puppy uses a simple route system which you can easily extend to add your own behaviour and get more interactivity. For example, you can create a form which will be handled in back-end with Puppy.


## Resources

[Website](http://www.puppyframework.com/) |
[puppy-application](https://github.com/Raphhh/puppy-application) |
[puppy-config](https://github.com/Raphhh/puppy-config) |
[puppy-service](https://github.com/Raphhh/puppy-service) |


## Installation

```
$ composer create-project raphhh/puppy path/to/my/project
```

## Run the demo

First, you have to know that public http access to Puppy is the dir '/public'. It is where you will put your css or your js.

### Use the built-in PHP server

Use the run command in your console:

```
$ bin/run
```

Then, you can launch Puppy in your browser at http://localhost:8080.

You can also specify you want to run the dev env (no cache).

```
$ bin/run dev
```

### Use any server

If Puppy is not the root of your site, create a local config with the base dir to redefine. For example, if you will launch Puppy in the root 'localhost/puppy/public', your local config will be:

```php
// config/local.php
<?php
return [
    'baseUrl' => '/puppy/public/', //use only a absolute path
];
```

Local config is not versioned and will never go to production. For more information about config, see specific section. 

See also how to set the dev env variable 'APP_ENV'.

Then, you can launch Puppy in your browser. :) 

### Clean the cache

To clean the cache, rebuild your project:

```
$ bin/build
```

## Create your own application

Now you want to code your site. Just be careful with the cache of Puppy. If Puppy is cached, your modifications will not appear in the screen. See the config section to disable the cache.

### Add new pages

Consider directory '/templates/public' like a mirror of your public site access, but specially dedicated to twig templates. For each page you want in your website, you have to put a twig file in this directory. Name this file as if it was a html file, but complete it with extension '.twig'.

For example, for a home page, normally you will use a 'index.html' at the root of your public area. Here, with Puppy, you have to create a file '/templates/public/index.html.twig'. Same name, but with specific extension. Then, open the base url of your website, and you will go to this template. You can also call the equivalent html file in your address: '/index.html'. :)

So, for example, these uri will call those twig:

 - / => templates/public/**index.html.twig**
 - /index.html => templates/public/**index.html.twig**
 - /contact.html => templates/public/**contact.html.twig**
 - /contact => templates/public/**contact/index.html.twig**
 - /contact/index.html => templates/public/**contact/index.html.twig**
 
### Create common private templates

Now, imagine you want to add a second page, like a contact page for example. So, you want to display a new template for the url '/contact.html'. You just have to create this new template in the file '/templates/public/contact.html.twig'.

Once you have create your second template file, there is some duplicated code in your html (header, menu, footer, ...). No problem, here comes Twig! You can, for example, group your common base html code in a separate file that each page will extend.

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

Add all your services you need. Puppy uses a simple service container.

```php
$application->addService('serviceName', function(\ArrayAccess $services){
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
 
