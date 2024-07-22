<?php

declare(strict_types = 1);

namespace App\Application;

class JsonHelper {
	public function sendResponse(mixed $data): void {
		$json = \json_encode($data, \JSON_THROW_ON_ERROR);
		\header('Content-Type: application/json');
		echo $json;
	}
}
