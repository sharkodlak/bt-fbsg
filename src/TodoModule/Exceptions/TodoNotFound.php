<?php

declare(strict_types = 1);

namespace App\TodoModule\Exceptions;

use Throwable;

class TodoNotFound extends TodoCreateException {
	public static function create(?string $message = null, ?Throwable $previous = null): self {
		$message ??= 'To-Do not found.';
		return new self($message, 404, $previous);
	}
}
