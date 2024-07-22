<?php

declare(strict_types = 1);

namespace App\TodoModule\Exceptions;

use Throwable;

/** phpcs:ignoreFile SlevomatCodingStandard.Classes.SuperfluousExceptionNaming.SuperfluousSuffix */
class TodoCreateException extends TodoRuntimeException implements Throwable {
	public static function create(?string $message = null, ?Throwable $previous = null): self {
		$message ??= 'To-Do creation failed.';
		return new self($message, 409, $previous);
	}
}
