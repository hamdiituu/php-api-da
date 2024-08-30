<?php

namespace Http\Routers;

use Core\Router;
use Core\Database;
use Data\Repositories\TodoRepository;
use Http\Controllers\TodoController;

class ApiRouter
{
    public static function register(Router $router)
    {
        $pdo = Database::connect();
        $todoRepository = new TodoRepository($pdo);
        $todoController = new TodoController($todoRepository);

        $router->group('/todos', function ($router) use ($todoController) {
            $router->get('/', [$todoController, 'getAll']);
            $router->get('/{id}', [$todoController, 'getById']);
            $router->post('/', [$todoController, 'create']);
            $router->put('/{id}', [$todoController, 'update']);
            $router->delete('/{id}', [$todoController, 'delete']);
        });
    }
}