<?php

namespace Todo\TaskBundle\Core;

use Silex\Application;
use Silex\Route;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class ControllerCore implements ControllerProviderInterface {

    protected $repository;

    protected $controller;

    public function setRepository($repository) {
        $this->repository = $repository;
    }

    public function setController($controller) {
        $this->controller = $controller;
    }

    public function __construct() {
        $calledClass = explode('\\', get_called_class());
        $class = end($calledClass);

        $this->setRepository(substr($class, 0, -10));
        $this->setController(new ControllerCollection(new Route()));
    }

    public function connect(Application $app)
    {
        $controller = $this->controller;

        $targetRepository = "Todo\\TaskBundle\\Repository\\" . $this->repository . "Repository";

        $controller->get("/", function() use ($app, $targetRepository) {
            $repository = new $targetRepository($app['db']);
            $results = $repository->findAll();

            return $app->json($results);
        });

        $controller->get("/{id}", function($id) use ($app, $targetRepository) {
            $repository = new $targetRepository($app['db']);
            $result = $repository->find($id);

            return $app->json($result);
        })
        ->assert('id', '\d+');

        $controller->post("/", function(Request $request) use ($app, $targetRepository) {
            $repository = new $targetRepository($app['db']);
            $params = $request->request->all();

            return $app->json($repository->insert($params));
        });

        $controller->put("/{id}", function(Request $request, $id) use ($app, $targetRepository) {
            $repository = new $targetRepository($app['db']);
            $params = $request->request->all();

            return $app->json($repository->update($id, $params));
        })
        ->assert('id', '\d+');

        $controller->delete("/{id}", function($id) use ($app, $targetRepository) {
            $repository = new $targetRepository($app['db']);

            return $app->json($repository->delete($id));
        })
        ->assert('id', '\d+');

        return $controller;
    }
}
