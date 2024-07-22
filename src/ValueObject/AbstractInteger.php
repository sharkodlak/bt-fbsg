<?php

declare(strict_types = 1);

namespace App\ValueObject;

use App\Exceptions\WrongInput;

abstract readonly class AbstractInteger {
	public static function create(string $i): static {
		if (\filter_var($i, \FILTER_VALIDATE_INT) === false) {
			$className = \basename(\str_replace('\\', '/', static::class));
			$msg = \sprintf('Wrong input, expected integer value for %s.', $className);
			throw WrongInput::create($msg);
		}

		return new static((int) $i);
	}

	final public function __construct(
		private int $value
	) {
	}

	public function __toString(): string {
		return (string) $this->value;
	}

	public function getValue(): int {
		return $this->value;
	}
}
