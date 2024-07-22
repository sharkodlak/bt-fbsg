<?php

declare(strict_types = 1);

namespace App\Application;

use App\Application\DI\Container;
use App\Application\Router\Router;
use Throwable;

class Application {
	private Container $container;

	private Router $router;

	public function __construct(
		private readonly Config $config
	) {
	}

	public function getConfig(): Config {
		return $this->config;
	}

	public function getContainer(): Container {
		return $this->container;
	}

	public function getRouter(): Router {
		if (!isset($this->router)) {
			$this->router = $this->container->get(Router::class);
		}

		return $this->router;
	}

	public function run(): void {
		// phpcs:ignore SlevomatCodingStandard.Variables.DisallowSuperGlobalVariable.DisallowedSuperGlobalVariable
		$uri = $_SERVER['REQUEST_URI'];
		// phpcs:ignore SlevomatCodingStandard.Variables.DisallowSuperGlobalVariable.DisallowedSuperGlobalVariable
		$method = $_SERVER['REQUEST_METHOD'];

		try {
			$this->getRouter()->dispatch($uri, $method);
		} catch (Throwable $e) {
			\http_response_code(500);
			echo $e->getMessage();
		}
	}

	public function setContainer(Container $container): void {
		$this->container = $container;
	}
}
