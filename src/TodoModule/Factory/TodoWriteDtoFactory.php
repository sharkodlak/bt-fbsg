<?php

declare(strict_types = 1);

namespace App\TodoModule\Factory;

use App\Exceptions\WrongInput;
use App\TodoModule\Dto\TodoWriteDto;
use App\TodoModule\Enum\Status;

class TodoWriteDtoFactory {
	/** @param array<string, string> $data */
	public function create(array $data): TodoWriteDto {
		$title = $this->validateTitle($data['title'] ?? null);
		$description = $this->validateDescription($data['description'] ?? null);
		$status = $this->validateStatus($data['status'] ?? null);

		return new TodoWriteDto($title, $description, $status);
	}

	private function validateTitle(mixed $title): string {
		if (!isset($title)) {
			throw WrongInput::create("Property 'title' is missing.");
		}

		if (!\is_string($title) || \trim($title) === '') {
			throw WrongInput::create("Property 'title' have to be non-empty string.");
		}

		return $title;
	}

	private function validateDescription(mixed $description): string {
		if (!isset($description)) {
			throw WrongInput::create("Property 'description' is missing.");
		}

		if (!\is_string($description) || \trim($description) === '') {
			throw WrongInput::create("Property 'description' have to be non-empty string.");
		}

		return $description;
	}

	private function validateStatus(mixed $input): Status {
		if (!isset($input)) {
			throw WrongInput::create("Property 'status' is missing.");
		}

		if (!\is_string($input) || \trim($input) === '') {
			throw WrongInput::create("Property 'status' have to be non-empty string.");
		}

		$status = Status::tryFrom($input);

		if ($status === null) {
			$msg = \sprintf(
				"Invalid status: '%s'. Must be either '%s' or '%s'.",
				$input,
				Status::PENDING->value,
				Status::COMPLETED->value
			);
			throw WrongInput::create($msg);
		}

		return $status;
	}
}
