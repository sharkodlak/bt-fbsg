<?php

declare(strict_types = 1);

namespace App\Application\Router;

class GroupRoute extends RootRoute {
	public function __construct(
		private string $path,
		callable $callback
	) {
		$callback($this);
	}

	public function getPath(): string {
		return $this->path;
	}
}
