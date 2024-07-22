<?php

declare(strict_types = 1);

namespace App\TodoModule\Repository;

use App\TodoModule\Dto\TodoWriteDto;
use App\TodoModule\Entity\Todo;
use App\TodoModule\ValueObject\TodoId;

interface TodoRepository {
	public function create(TodoWriteDto $newTodoDto): TodoId;

	public function delete(TodoId $id): bool;

	public function find(TodoId $id): ?Todo;

	/**
	 * @return array<Todo>
	 */
	public function findAll(): array;

	public function update(TodoId $id, TodoWriteDto $todoWriteDto): bool;
}
