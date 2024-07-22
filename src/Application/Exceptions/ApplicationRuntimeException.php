<?php

declare(strict_types = 1);

namespace App\Application\Exceptions;

use RuntimeException;

/** phpcs:ignoreFile SlevomatCodingStandard.Classes.SuperfluousExceptionNaming.SuperfluousSuffix */
class ApplicationRuntimeException extends RuntimeException {
	private mixed $extra;

	public function setExtra(mixed $extra): void {
		$this->extra = $extra;
	}

	public function getExtra(): mixed {
		return $this->extra ?? null;
	}
}
