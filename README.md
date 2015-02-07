# Puppy - a brave and faithful micro-framework

[![Latest Stable Version](https://poser.pugx.org/raphhh/puppy/v/stable.svg)](https://packagist.org/packages/raphhh/puppy)
[![Build Status](https://travis-ci.org/Raphhh/puppy.png)](https://travis-ci.org/Raphhh/puppy)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/Raphhh/puppy/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Raphhh/puppy/)
[![Code Coverage](https://scrutinizer-ci.com/g/Raphhh/puppy/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Raphhh/puppy/)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/_/mini.png)](https://insight.sensiolabs.com/projects/_)
[![Dependency Status](https://www.versioneye.com/user/projects/54062eb9c4c187ff6100006f/badge.svg?style=flat)](https://www.versioneye.com/user/projects/54062eb9c4c187ff6100006f)
[![Total Downloads](https://poser.pugx.org/raphhh/puppy/downloads.svg)](https://packagist.org/packages/raphhh/puppy)
[![Reference Status](https://www.versioneye.com/php/raphhh:puppy/reference_badge.svg?style=flat)](https://www.versioneye.com/php/raphhh:puppy/references)
[![License](https://poser.pugx.org/raphhh/puppy/license.svg)](https://packagist.org/packages/raphhh/puppy)

Puppy is micro-framework build in PHP. 
It runs for you with happiness and creates static websites using [Twig templates](http://twig.sensiolabs.org/)!

## Installation

```
$ composer create-project raphhh/puppy path/to/my/project
```

## Static website with Twig

Puppy is a brave friend of your static site. It will give you more power with the help of Twig. 
So, you will be able to build your website directly in Twig, without any problems of routes or configuration.

### Link a page to a template

Consider directory '/templates/public' like a mirror of your public site access, but specially dedicated to twig templates. 
For each page you want in your website, you have to put a twig file in this directory. 
Name this file as it was a html file, but complete it with extension '.twig'.

For example, for a home page, normally you will use a 'index.html' at the root of your public area. 
Here, with Puppy, you have to create a file '/templates/public/index.html.twig'. Same name, but with specific extension.
Then, open the base url of your website (e.i. www.mysite.com), and you will go to this template.
You can also call the equivalent html file in your address: www.mysite.com/index.html. :)

Now, imagine you want to add a second page, like a contact page for example. 
So, you want to display a new template for the url 'www.mysite.com/contact.html'.
You just have to create this new template in the file '/templates/public/contact.html.twig'.
 
### Create common private template

Once you have create your second template file, there is some duplicated code in your html. No problem, here comes Twig! 
You can, for example, group your common base html in a separate file that each page will extend.
As this file must not be directly accessible from a url, it must not appear in the '/templates/public' dir. 
You have to put it directly at the root of the '/templates' dir. So, it will never be called from any url.

### Add some specific behaviour

Now, imagine you have a form in your contact page, sending a email.
You can easily add a function to handle your form in php.
See the DemoModule to know how to proceed.

## Config

Add all your config you want, depending on each environment.
Puppy uses an easy config provider. 
For more information, see [puppy-config](https://github.com/Raphhh/puppy-config) documentation.

## Routes

Add any special routes you want for particular behaviour.
Puppy uses a complete route provider. 
For more information, see [puppy-application](https://github.com/Raphhh/puppy-application) documentation.

## Services

Add all your services you need.
Puppy uses a simple service container.
For more information, see [puppy-application](https://github.com/Raphhh/puppy-application) documentation.

Puppy is build with pre-config services for session and template. 
For more information, see [puppy-service](https://github.com/Raphhh/puppy-service) documentation.
