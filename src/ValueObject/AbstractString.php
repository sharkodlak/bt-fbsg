<?php

declare(strict_types = 1);

namespace App\ValueObject;

abstract readonly class AbstractString {
	public function __construct(
		private string $value
	) {
	}

	public function __toString(): string {
		return $this->value;
	}

	public function getValue(): string {
		return $this->value;
	}
}
