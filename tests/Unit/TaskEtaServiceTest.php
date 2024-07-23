<?php

namespace Tests\Unit;

use App\Services\TaskEtaService;
use App\Services\WorkingDayService;
use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class TaskEtaServiceTest extends TestCase
{
    private WorkingDayService&MockObject $workingDayService;

    private TaskEtaService $taskEtaService;

    public function setUp(): void
    {
        $this->workingDayService = $this->createMock(WorkingDayService::class);
        $this->taskEtaService = new TaskEtaService($this->workingDayService);
    }

    public function testInstantDone(): void
    {
        $start = '2024-07-23 09:00:00';
        $startdate = new DateTimeImmutable($start);
        $eta = $this->taskEtaService->calculate('CZ', $startdate, 0, false, '08:00', '17:00');
        self::assertSame($start, $eta->getDate()->format('Y-m-d H:i:s'));
    }

    public function testInstantDoneOnSaturday(): void
    {
        $start = '2024-07-20 09:00:00';
        $startdate = new DateTimeImmutable($start);
        $eta = $this->taskEtaService->calculate('CZ', $startdate, 0, false, '08:00', '17:00');
        self::assertSame('2024-07-20 09:00:00', $eta->getDate()->format('Y-m-d H:i:s'));
    }

    public function testInstantDoneOnSunday(): void
    {
        $start = '2024-07-20 23:00:00';
        $startdate = new DateTimeImmutable($start);
        $eta = $this->taskEtaService->calculate('CZ', $startdate, 0, false, '08:00', '17:00');
        self::assertSame('2024-07-21 08:00:00', $eta->getDate()->format('Y-m-d H:i:s'));
    }

    public function testInstantDoneAfterEaster(): void
    {
        $this->workingDayService->expects(self::atMost(10))
            ->method('isWorkingDay')
            ->willReturnCallback(function ($state, DateTimeInterface $date) {
                $startDate = new DateTimeImmutable('2024-03-29 00:00:00');
                $endDate = new DateTimeImmutable('2024-04-01 23:59:59');
                return $date < $startDate || $date > $endDate;
            })
        ;
        $start = '2024-03-28 23:00:00';
        $startdate = new DateTimeImmutable($start);
        $eta = $this->taskEtaService->calculate('CZ', $startdate, 0, true, '08:00', '17:00');
        self::assertSame('2024-04-02 08:00:00', $eta->getDate()->format('Y-m-d H:i:s'));
    }

    public function testOneDayTask(): void
    {
        $this->workingDayService->expects(self::atMost(10))
            ->method('isWorkingDay')
            ->willReturn(true)
        ;
        $start = '2024-07-23 12:00:00';
        $startdate = new DateTimeImmutable($start);
        $eta = $this->taskEtaService->calculate('CZ', $startdate, 60, true, '08:00', '17:00');
        self::assertSame('2024-07-23 13:00:00', $eta->getDate()->format('Y-m-d H:i:s'));
    }

    public function testOneDayTaskAfterHours(): void
    {
        $this->workingDayService->expects(self::atMost(10))
            ->method('isWorkingDay')
            ->willReturn(true)
        ;
        $start = '2024-07-23 18:00:00';
        $startdate = new DateTimeImmutable($start);
        $eta = $this->taskEtaService->calculate('CZ', $startdate, 60, true, '08:00', '17:00');
        self::assertSame('2024-07-24 09:00:00', $eta->getDate()->format('Y-m-d H:i:s'));
    }

    public function testOneDayTaskAfterWeekend(): void
    {
        $this->workingDayService->expects(self::exactly(3))
            ->method('isWorkingDay')
            ->willReturnOnConsecutiveCalls(false, false, true)
        ;
        $start = '2024-07-20 12:00:00';
        $startdate = new DateTimeImmutable($start);
        $eta = $this->taskEtaService->calculate('CZ', $startdate, 60, true, '08:00', '17:00');
        self::assertSame('2024-07-22 09:00:00', $eta->getDate()->format('Y-m-d H:i:s'));
    }

    public function testTwoDaysTask(): void
    {
        $this->workingDayService->expects(self::exactly(4))
            ->method('isWorkingDay')
            ->willReturnOnConsecutiveCalls(true, false, false, true)
        ;
        $start = '2024-07-19 16:00:00';
        $startdate = new DateTimeImmutable($start);
        $eta = $this->taskEtaService->calculate('CZ', $startdate, 2 * 60, true, '08:00', '17:00');
        self::assertSame('2024-07-22 09:00:00', $eta->getDate()->format('Y-m-d H:i:s'));
    }

    public function testEightDaysTaskOverEaster(): void
    {
        $this->workingDayService->expects(self::atMost(12))
            ->method('isWorkingDay')
            ->willReturnCallback(function ($state, DateTimeInterface $date) {
                $startDate = new DateTimeImmutable('2024-03-29 00:00:00');
                $endDate = new DateTimeImmutable('2024-04-01 23:59:59');
                return $date < $startDate || $date > $endDate;
            })
        ;
        $start = '2024-03-25 08:00:00';
        $startdate = new DateTimeImmutable($start);
        $eta = $this->taskEtaService->calculate('CZ', $startdate, 8 * 8 * 60, true, '08:00', '16:00');
        self::assertSame('2024-04-05 16:00:00', $eta->getDate()->format('Y-m-d H:i:s'));
    }
}
