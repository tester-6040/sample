<?php

declare(strict_types=1);

function analyze_cycles(array $periods): array
{
    if (count($periods) < 2) {
        return ['avg_cycle' => 28, 'avg_period' => 5, 'next_period' => null, 'ovulation' => null, 'fertile_start' => null, 'fertile_end' => null, 'irregular' => false];
    }

    $cycleLengths = [];
    $periodLengths = [];
    for ($i = 1; $i < count($periods); $i++) {
        $prev = new DateTimeImmutable($periods[$i - 1]['start_date']);
        $curr = new DateTimeImmutable($periods[$i]['start_date']);
        $cycleLengths[] = (int)$prev->diff($curr)->days;
    }
    foreach ($periods as $p) {
        if (!empty($p['end_date'])) {
            $start = new DateTimeImmutable($p['start_date']);
            $end = new DateTimeImmutable($p['end_date']);
            $periodLengths[] = max(1, (int)$start->diff($end)->days + 1);
        }
    }
    $avgCycle = (int)round(array_sum($cycleLengths) / count($cycleLengths));
    $avgPeriod = $periodLengths ? (int)round(array_sum($periodLengths)/count($periodLengths)) : 5;
    $lastStart = new DateTimeImmutable(end($periods)['start_date']);
    $next = $lastStart->modify("+{$avgCycle} days");
    $ovu = $next->modify('-14 days');

    return [
        'avg_cycle' => $avgCycle,
        'avg_period' => $avgPeriod,
        'next_period' => $next->format('Y-m-d'),
        'ovulation' => $ovu->format('Y-m-d'),
        'fertile_start' => $ovu->modify('-5 days')->format('Y-m-d'),
        'fertile_end' => $ovu->modify('+1 days')->format('Y-m-d'),
        'irregular' => (max($cycleLengths)-min($cycleLengths)) > 7,
    ];
}
