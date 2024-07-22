<?php

declare(strict_types = 1);

namespace App\TodoModule\Service;

use App\TodoModule\Entity\Todo;
use App\TodoModule\Exceptions\TodoNotFound;
use App\TodoModule\Repository\TodoRepository;
use App\TodoModule\ValueObject\TodoId;

class TodoReadService {
	public function __construct(
		private readonly TodoRepository $todoRepository
	) {
	}

	public function get(TodoId $id): Todo {
		$todo = $this->todoRepository->find($id);

		if ($todo === null) {
			throw TodoNotFound::create();
		}

		return $todo;
	}

	/**
	 * @return array<Todo>
	 */
	public function getAll(): array {
		return $this->todoRepository->findAll();
	}
}
