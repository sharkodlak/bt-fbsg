<?php

declare(strict_types = 1);

namespace App\TodoModule\Enum;

enum Status: string {
	case PENDING = 'pending';
	case COMPLETED = 'completed';
}
