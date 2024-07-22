<?php

declare(strict_types = 1);

namespace App\Application\Router;

use App\Application\Router\Interfaces\RouteGroupInterface;
use App\Application\Router\Interfaces\RouteInterface;
use App\Application\Router\Traits\DispatchTrait;
use App\Application\Router\Traits\MethodsTrait;

class RootRoute implements RouteGroupInterface {
	use DispatchTrait;
	use MethodsTrait;

	/** @var array<RouteGroupInterface|RouteInterface> $routes */
	private array $routes = [];

	public function group(string $path, callable $callback): self {
		$group = new GroupRoute($path, $callback);
		$this->routes[] = $group;

		return $this;
	}

	public function add(string $method, string $path, callable $callback): self {
		$route = new Route($method, $path, $callback);
		$this->routes[] = $route;

		return $this;
	}

	public function getPath(): string {
		return '';
	}

	/**
	 * @return array<RouteGroupInterface|RouteInterface>
	 */
	protected function getRoutes(): array {
		return $this->routes;
	}
}
