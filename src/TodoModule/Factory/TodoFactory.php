<?php

declare(strict_types = 1);

namespace App\TodoModule\Factory;

use App\TodoModule\Entity\Todo;
use App\TodoModule\ValueObject\Description;
use App\TodoModule\ValueObject\Status;
use App\TodoModule\ValueObject\Title;
use App\TodoModule\ValueObject\TodoId;

class TodoFactory {
	public function create(
		int $todoId,
		string $title,
		string $description,
		string $status
	): Todo {
		$todoIdVO = new TodoId($todoId);
		$titleVO = new Title($title);
		$descriptionVO = new Description($description);
		$statusVO = new Status($status);

		return new Todo($todoIdVO, $titleVO, $descriptionVO, $statusVO);
	}
}
