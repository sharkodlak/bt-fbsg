<?php

declare(strict_types = 1);

namespace App\TodoModule\Controller;

use App\Application\Controller;
use App\Application\Exceptions\ApplicationRuntimeException;
use App\TodoModule\Exceptions\TodoNotDeleted;
use App\TodoModule\Exceptions\TodoNotModified;
use App\TodoModule\Factory\TodoWriteDtoFactory;
use App\TodoModule\Service\TodoReadService;
use App\TodoModule\Service\TodoWriteService;
use App\TodoModule\ValueObject\TodoId;
use Throwable;

class TodoController extends Controller {
	public function __construct(
		private readonly TodoReadService $todoReadService,
		private readonly TodoWriteService $todoWriteService,
		private readonly TodoWriteDtoFactory $todoWriteDtoFactory
	) {
	}

	public function getAll(): void {
		try {
			$todos = $this->todoReadService->getAll();
			$data = [ 'todos' => $todos ];
			$this->sendJsonResponse($data);
		} catch (Throwable $e) {
			$this->handleException($e);
		}
	}

	public function create(): void {
		try {
			$data = $this->getDataFromJsonBody();
			$todoWriteDto = $this->todoWriteDtoFactory->create($data);
			$todoId = $this->todoWriteService->create($todoWriteDto);
			$data = [
				'id' => $todoId->getValue(),
			];
			\http_response_code(201);
			$this->sendJsonResponse($data);
		} catch (Throwable $e) {
			$this->handleException($e);
		}
	}

	public function get(string $id): void {
		try {
			$todoId = TodoId::create($id);
			$todo = $this->todoReadService->get($todoId);
			$this->sendJsonResponse($todo);
		} catch (Throwable $e) {
			$this->handleException($e);
		}
	}

	public function update(string $id): void {
		try {
			$todoId = TodoId::create($id);
			$data = $this->getDataFromJsonBody();
			$todoWriteDto = $this->todoWriteDtoFactory->create($data);
			$modified = $this->todoWriteService->update($todoId, $todoWriteDto);

			if (!$modified) {
				throw TodoNotModified::create();
			}

			\http_response_code(204);
		} catch (Throwable $e) {
			$this->handleException($e);
		}
	}

	public function delete(string $id): void {
		try {
			$todoId = TodoId::create($id);
			$deleted = $this->todoWriteService->delete($todoId);

			if (!$deleted) {
				throw TodoNotDeleted::create();
			}

			\http_response_code(204);
		} catch (Throwable $e) {
			$this->handleException($e);
		}
	}

	private function handleException(\Throwable $e): void {
		$status = $e instanceof ApplicationRuntimeException ? $e->getCode() : 500;
		$error = [
			'error' => $e->getMessage(),
			'code' => $e->getCode(),
		];
		\http_response_code($status);
		$this->sendJsonResponse($error);
	}
}
