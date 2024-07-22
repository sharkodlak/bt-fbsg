<?php

declare(strict_types = 1);

namespace App\Application;

use App\Exceptions\WrongInput;

abstract class Controller {
	private JsonHelper $jsonHelper;

	private string $input;

	public function injectInput(string $input): void {
		$this->input = $input;
	}

	public function sendJsonResponse(mixed $data): void {
		$this->jsonHelper->sendResponse($data);
	}

	public function setJsonHelper(JsonHelper $jsonHelper): void {
		$this->jsonHelper = $jsonHelper;
	}

	/**
	 * @return array<string, string>
	 */
	protected function getDataFromJsonBody(): array {
		$json = $this->input;
		$data = \json_decode($json, true);

		if (!\is_array($data)) {
			throw WrongInput::create('Invalid input. Expected an JSON object.');
		}

		return $data;
	}
}
