<?php

declare(strict_types=1);

namespace App\Services;

use DateInterval;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;

class TaskEtaService {
    private const MINUTES_PER_DAY = 24 * 60;

    public function __construct(
        private WorkingDayService $workingDayService,
    ) {
    }

    public function getWorkingDayService(): WorkingDayService
    {
        return $this->workingDayService;
    }

    public function calculate(
        string $state,
        DateTimeInterface $start,
        int $estimatedMinutes,
        bool $onlyWorkingDays,
        string $workingHoursStart,
        string $workingHoursEnd
    ): DateTimeInterface
    {
        $remaining = $estimatedMinutes;
        $workingHours = [
            'start' => array_map('intval', explode(':', $workingHoursStart)),
            'end' => array_map('intval', explode(':', $workingHoursEnd)),
        ];
        $current = DateTimeImmutable::createFromInterface($start);
        $dailyWork = [];

        if ($current->format('H:i') < $workingHoursStart) {
            $current = $current->setTime(...$workingHours['start']);
        }

        while ($remaining > 0) {
            $isWorkingDay = !$onlyWorkingDays || $this->workingDayService->isWorkingDay($state, $current);
            $todayWork = 0;

            if ($isWorkingDay) {
                $currentWorkingHoursEnd = $current->setTime(...$workingHours['end']);
                $diff = $current->diff($currentWorkingHoursEnd);
                $diffMinutes = $diff->h * 60 + $diff->i;
                $todayWork = min($diffMinutes, $remaining);
                $current = $current->modify("+ $todayWork minutes");
                $remaining -= $diffMinutes;
            }

            $dailyWork[$current->format('Y-m-d')] = $todayWork;

            if ($remaining <= 0) {
                break;
            }

            $current = $current->modify('+ 1 day')
                ->setTime(...$workingHours['start']);
        }

        return $current;
    }
}
