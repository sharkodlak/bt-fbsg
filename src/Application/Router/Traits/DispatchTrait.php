<?php

declare(strict_types = 1);

namespace App\Application\Router\Traits;

use App\Application\Router\Interfaces\RouteInterface;

/** phpcs:ignoreFile SlevomatCodingStandard.Classes.SuperfluousExceptionNaming.SuperfluousSuffix */
trait DispatchTrait {
	/** @var array<string, string> $params */
	private array $params;

	public function dispatch(string $uri, string $method): bool {
		$pathParts = \explode('/', $this->getPath());
		$uriParts = \explode('/', $uri);
		$match = true;

		foreach ($pathParts as $part) {
			$uriPart = \array_shift($uriParts);

			if (\str_starts_with($part, '{') && \str_ends_with($part, '}') && $uriPart !== '' && $uriPart !== null) {
				$name = substr($part, 1, -1);
				$this->params[$name] = $uriPart;
				continue;
			}

			if ($part !== $uriPart) {
				$match = false;
				break;
			}
		}

		if (!$match) {
			return false;
		}

		$rest = '/' . \implode('/', $uriParts);

		if ($this instanceof RouteInterface) {
			$namedParams = $this->getParams();
			$params = array_values($namedParams);
			$executed = $this->execute($method, ...$params);

			if ($executed) {
				return true;
			}
		} else {
			foreach ($this->getRoutes() as $route) {
				$executed = $route->dispatch($rest, $method);

				if ($executed) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * @return array<string, string>
	 */
	private function getParams(): array {
		return $this->params ?? [];
	}
}
