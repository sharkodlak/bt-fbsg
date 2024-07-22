<?php

declare(strict_types = 1);

namespace App\TodoModule\Entity;

use App\TodoModule\ValueObject\Description;
use App\TodoModule\ValueObject\Status;
use App\TodoModule\ValueObject\Title;
use App\TodoModule\ValueObject\TodoId;
use JsonSerializable;

readonly class Todo implements JsonSerializable {
	public function __construct(
		private TodoId $id,
		private Title $title,
		private Description $description,
		private Status $status
	) {
	}

	public function getId(): TodoId {
		return $this->id;
	}

	public function getTitle(): Title {
		return $this->title;
	}

	public function getDescription(): Description {
		return $this->description;
	}

	public function getStatus(): Status {
		return $this->status;
	}

	public function jsonSerialize(): mixed {
		return $this->toArray();
	}

	/**
	 * @return array<string, float|string>
	 */
	public function toArray(): array {
		return [
			'id' => $this->id->getValue(),
			'title' => $this->title->getValue(),
			'description' => $this->description->getValue(),
			'status' => $this->status->getValue(),
		];
	}
}
