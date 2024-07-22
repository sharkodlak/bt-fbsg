<?php

declare(strict_types = 1);

namespace App\TodoModule\Exceptions;

use Throwable;

class TodoAlreadyExists extends TodoCreateException {
	public static function create(?string $message = null, ?Throwable $previous = null): self {
		$message ??= 'To-Do already exists.';
		return new self($message, 409, $previous);
	}
}
