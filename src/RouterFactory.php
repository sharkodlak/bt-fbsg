<?php

declare(strict_types = 1);

namespace App;

use App\Application\DI\Container;
use App\Application\Router\Interfaces\RouteGroupInterface;
use App\TodoModule\Controller\TodoController;

class RouterFactory {
	public function __construct(
		private readonly Container $container
	) {
	}

	public function registerRoutes(RouteGroupInterface $root): void {
		$root->group('/api', function (RouteGroupInterface $api): void {
			$api->group('/todos', function (RouteGroupInterface $todos): void {
				$todoController = $this->container->get(TodoController::class);

				$todos->get('/{id}', [ $todoController, 'get' ]);
				$todos->put('/{id}', [ $todoController, 'update' ]);
				$todos->delete('/{id}', [ $todoController, 'delete' ]);
				$todos->get('', [ $todoController, 'getAll' ]);
				$todos->post('', [ $todoController, 'create' ]);
			});
		});
	}
}
