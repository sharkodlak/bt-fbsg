<?php

declare(strict_types = 1);

namespace App\Application\Router\Traits;

use App\Application\Router\Interfaces\RouteGroupInterface;
use App\Application\Router\Interfaces\RouteInterface;

/** phpcs:ignoreFile SlevomatCodingStandard.Classes.SuperfluousExceptionNaming.SuperfluousSuffix */
trait MethodsTrait {
	public function get(string $path, callable $callback): RouteGroupInterface {
		return $this->add(RouteInterface::GET, $path, $callback);
	}

	public function post(string $path, callable $callback): RouteGroupInterface {
		return $this->add(RouteInterface::POST, $path, $callback);
	}

	public function put(string $path, callable $callback): RouteGroupInterface {
		return $this->add(RouteInterface::PUT, $path, $callback);
	}

	public function delete(string $path, callable $callback): RouteGroupInterface {
		return $this->add(RouteInterface::DELETE, $path, $callback);
	}
}
