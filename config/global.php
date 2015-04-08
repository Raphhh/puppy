<?php
return [
    'baseUrl' => '/',
    'cache.path' => 'vars/cache',
    'template.directory.main' => 'templates',
    'template.directory.cache' => '%cache.path%/template',
    'module.cache.enable' => true,
    'module.cache.options' => ['path' => '%cache.path%/module', 'driver' => 'Stash\Driver\FileSystem'],
];
