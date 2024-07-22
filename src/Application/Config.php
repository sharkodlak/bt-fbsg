<?php

declare(strict_types = 1);

namespace App\Application;

readonly class Config {
	private string $dbHost;

	private string $dbUser;

	private string $dbPass;

	private string $dbName;

	/**
	 * @param array<string, string> $envs
	 */
	public function __construct(array $envs) {
		$this->dbHost = $envs['DB_HOST'];
		$this->dbUser = $envs['DB_USER'];
		$this->dbPass = $envs['DB_PASS'];
		$this->dbName = $envs['DB_NAME'];
	}

	public function getDbHost(): string {
		return $this->dbHost;
	}

	public function getDbUser(): string {
		return $this->dbUser;
	}

	public function getDbPass(): string {
		return $this->dbPass;
	}

	public function getDbName(): string {
		return $this->dbName;
	}
}
