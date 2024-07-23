<?php

declare(strict_types=1);

namespace App\Dto;

use DateTimeInterface;

class EtaDto {
    /**
     * @param array<string, int> $dailyWork
     */
    public function __construct(
        private DateTimeInterface $date,
        private array $dailyWork,
    ) {
    }

    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @return array<string, int>
     */
    public function getDailyWork(): array
    {
        return $this->dailyWork;
    }
}
