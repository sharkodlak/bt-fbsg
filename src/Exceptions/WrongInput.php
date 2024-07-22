<?php

declare(strict_types = 1);

namespace App\Exceptions;

use Throwable;

class WrongInput extends AppRuntimeException {
	public static function create(?string $message = null, ?Throwable $previous = null): self {
		$message ??= 'Wrong input.';
		return new self($message, 400, $previous);
	}
}
