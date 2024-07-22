<?php

declare(strict_types = 1);

namespace App\TodoModule\Exceptions;

use Throwable;

class TodoNotModified extends TodoNotFound {
	public static function create(?string $message = null, ?Throwable $previous = null): self {
		$message ??= 'To-Do is not modified.';
		return new self($message, 404, $previous);
	}
}
