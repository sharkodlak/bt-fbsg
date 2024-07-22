<?php

declare(strict_types = 1);

namespace App\Application\Router;

use App\Application\Router\Interfaces\RouteInterface;
use App\Application\Router\Traits\DispatchTrait;
use Closure;

class Route implements RouteInterface {
	use DispatchTrait;

	private readonly Closure $callback;

	public function __construct(
		private string $method,
		private string $path,
		callable $callback
	) {
		$this->callback = Closure::fromCallable($callback);
	}

	public function getPath(): string {
		return $this->path;
	}

	public function execute(string $method, string ...$params): bool {
		if ($this->method === $method) {
			($this->callback)(...$params);
			return true;
		}

		return false;
	}
}
