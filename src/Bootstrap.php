<?php

declare(strict_types = 1);

namespace App;

use App\Application\Application;
use App\Application\Config;
use App\Application\DI\Container;
use Symfony\Component\Dotenv\Dotenv;

class Bootstrap {
	private Config $config;

	public function boot(): Config {
		$dotenv = new Dotenv();
		$dotenv->load(__DIR__ . '/../.env');

		// phpcs:ignore SlevomatCodingStandard.Variables.DisallowSuperGlobalVariable.DisallowedSuperGlobalVariable
		$this->config = new Config($_ENV);

		return $this->config;
	}

	public function createApplication(): Application {
		$application = new Application($this->config);
		$this->createContainer($application);
		$this->registerRoutes($application);

		return $application;
	}

	public function createContainer(Application $application): Container {
		$containerFactory = new ContainerFactory();
		$container = $containerFactory->create($this->config);
		$application->setContainer($container);

		return $container;
	}

	public function registerRoutes(Application $application): void {
		$container = $application->getContainer();
		$router = $application->getRouter();
		$root = $router->getRoot();
		$routerFactory = new RouterFactory($container);
		$routerFactory->registerRoutes($root);
	}
}
