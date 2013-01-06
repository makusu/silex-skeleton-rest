<?php

$app['debug'] = true;

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_mysql',
        'dbname'   => 'tododb',
        'host'     => 'localhost',
        'user'     => 'root',
        'password' => '123456'
    ),
));
