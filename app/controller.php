<?php

$app->mount('/item', new Todo\TaskBundle\Controller\ItemController());

$app->get('/', function () {
    return "Welcome To ReSTful API";
});
