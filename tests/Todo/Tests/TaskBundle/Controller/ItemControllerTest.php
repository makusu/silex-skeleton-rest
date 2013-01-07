<?php

namespace Todo\Tests\TaskBundle\Controller;

use Silex\WebTestCase;

class ItemControllerTest extends WebTestCase
{
    public function createApplication() {
        return require $_SERVER['APP_DIR'] . "/app_test.php";
    }

    public function testInitialPage()
    {
    }
}
