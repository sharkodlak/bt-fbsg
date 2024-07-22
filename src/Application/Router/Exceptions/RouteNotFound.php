<?php

declare(strict_types = 1);

namespace App\Application\Router\Exceptions;

use Exception;

class RouteNotFound extends Exception {
	public function __construct(string $path) {
		parent::__construct('Route not found: ' . $path, 404);
	}
}
