<?php

namespace Todo\Tests\TaskBundle\Core;

use Silex\WebTestCase;

class ControllerCoreTest extends WebTestCase {

    private $controllerName = 'item';

    public function createApplication() {
        return require $_SERVER['APP_DIR'] . "/app_test.php";
    }

    public function testGet()
    {
        $client = static::createClient();
        $client->request('GET', "/$this->controllerName/");
        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        $expected = array('id' => '2', 'name' => 'Utilize the skeleton so I can use it for my project.', 'created' => '2013-01-06 19:00:00');
        $actual = $data[1];
        $this->assertSame($expected, $actual);
    }

    public function testGet_inputId1()
    {
        $inputId = "1";
        $client = static::createClient();
        $client->request('GET', "/$this->controllerName/$inputId");
        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        $expected = array('id' => '1', 'name' => 'Download silex-skeleton-rest.', 'created' => '2013-01-01 00:00:00');
        $actual = $data;
        $this->assertSame($expected, $actual);
    }

    public function testPost_inputNameFooBar()
    {
        $inputName = 'Foo Bar';

        $client = static::createClient();

        $client->request('GET', "/$this->controllerName/");
        $expected = count(json_decode($client->getResponse()->getContent(), true)) + 1;

        $client->request('POST', "/$this->controllerName/", array('name' => $inputName));
        $client->request('GET', "/$this->controllerName/");
        $actual = count(json_decode($client->getResponse()->getContent(), true));

        $this->assertSame($expected, $actual);
    }

    public function testPut_inputId2NameFooBar()
    {
        $inputId = "2";
        $inputName = 'Foo Bar';

        $client = static::createClient();

        $client->request('PUT', "/$this->controllerName/$inputId", array('name' => $inputName));
        $client->request('GET', "/$this->controllerName/$inputId");

        $expected = array('id' => $inputId, 'name' => $inputName, 'created' => '2013-01-06 19:00:00');
        $actual = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame($expected, $actual);
    }

    public function testDelete_inputId5()
    {
        $inputId = '2';

        $client = static::createClient();

        $client->request('GET', "/$this->controllerName/");
        $expected = count(json_decode($client->getResponse()->getContent(), true)) - 1;

        $client->request('DELETE', "/$this->controllerName/$inputId");
        $client->request('GET', "/$this->controllerName/");
        $actual = count(json_decode($client->getResponse()->getContent(), true));

        $this->assertSame($expected, $actual);
    }
}
