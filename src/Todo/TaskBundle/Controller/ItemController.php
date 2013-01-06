<?php

namespace Todo\TaskBundle\Controller;

use Silex\Application;

use Todo\TaskBundle\Core\ControllerCore;
use Todo\TaskBundle\Repository;

class ItemController extends ControllerCore
{
    public function connect(Application $app) {
        $controller = $this->controller;

        // In here, you can write additional controller
        // or overwrite existing controller in ControllerCore

        parent::connect($app);
        return $controller;
    }
}
