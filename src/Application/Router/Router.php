<?php

declare(strict_types = 1);

namespace App\Application\Router;

class Router {
	private RootRoute $root;

	public function __construct() {
		$this->root = new RootRoute();
	}

	public function dispatch(string $uri, string $method): bool {
		$uriPath = \parse_url($uri, \PHP_URL_PATH);
		\assert(\is_string($uriPath));
		return $this->root->dispatch($uriPath, $method);
	}

	public function getRoot(): RootRoute {
		return $this->root;
	}
}
