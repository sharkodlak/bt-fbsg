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
        //private WorkingDayService $workingDayService,
    ) {
    }

    public function calculate(
        DateTimeInterface $start,
        int $estimatedMinutes,
        bool $onlyWorkingDays,
        string $workingHoursStart,
        string $workingHoursEnd
    ): DateTimeInterface
    {
        $workingHours = [
            'start' => array_map('intval', explode(':', $workingHoursStart)),
            'end' => array_map('intval', explode(':', $workingHoursEnd)),
        ];
        $workingTime = (
                ($workingHours['end'][0] - $workingHours['start'][0]) * 60
                + $workingHours['end'][1] - $workingHours['start'][1]
                + self::MINUTES_PER_DAY
            ) % self::MINUTES_PER_DAY
        ;
        $daysAtLeast = (int) floor($estimatedMinutes / $workingTime);
        $rest = $estimatedMinutes % $workingTime;

        if (!$onlyWorkingDays) {
            $current = DateTimeImmutable::createFromInterface($start)
                ->modify('+ ' . $daysAtLeast . ' days');
        } else {
            throw new \Exception('Not implemented');
        }

        if ($current->format('H:i') < $workingHoursStart) {
            $current = $current->setTime(...$workingHours['start']);
        }

        $currentWorkingHoursEnd = $current->setTime(...$workingHours['end']);
        $diff = $current->diff($currentWorkingHoursEnd);
        $diffMinutes = $diff->h * 60 + $diff->i;

        $rest -= $diffMinutes;

        if ($rest > 0) {
            $current = $current->modify('+ 1 day')
                ->setTime(...$workingHours['start'])
                ->modify('+ ' . $rest . ' minutes');
        }

        return $current;
    }
}