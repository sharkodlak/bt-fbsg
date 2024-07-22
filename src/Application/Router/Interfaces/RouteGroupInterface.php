<?php

declare(strict_types = 1);

namespace App\Application\Router\Interfaces;

/** phpcs:ignoreFile SlevomatCodingStandard.Classes.SuperfluousExceptionNaming.SuperfluousSuffix */
interface RouteGroupInterface {
	public function group(string $path, callable $callback): self;

	public function add(string $method, string $path, callable $callback): self;

	public function get(string $path, callable $callback): self;

	public function post(string $path, callable $callback): self;

	public function put(string $path, callable $callback): self;

	public function delete(string $path, callable $callback): self;

	public function dispatch(string $uri, string $method): bool;

	public function getPath(): string;
}
