<?php

declare(strict_types = 1);

namespace App\Application\DI;

class Container {
	/** @var array<string, object> */
	private array $services = [];

	/**
	 * @template T of object
	 * @param class-string<T> $name
	 * @return T
	 */
	public function get(string $name): object {
		/** @var T $service */
		$service = $this->services[$name];

		return $service;
	}

	public function set(object $service, ?string $name = null): void {
		if ($name === null) {
			$name = $service::class;
		}

		$this->services[$name] = $service;
	}
}
