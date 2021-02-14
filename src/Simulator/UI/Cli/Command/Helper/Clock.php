<?php

namespace App\Simulator\UI\Cli\Command\Helper;

class Clock
{
    const HOURS_IN_MINUTE = 60;
    const MICROSECONDS = 100;
    private int $startHour;
    private int $finishHour;
    private int $startMinute;
    public int $actualHour;
    public int $actualMinute;

    public function __construct($startHour, $finishHour, $startMinute)
    {
        $this->startHour = $startHour;
        $this->finishHour = $finishHour;
        $this->startMinute = $startMinute;
        $this->actualHour = 0;
        $this->actualMinute = 0;
    }

    public function __invoke($execute)
    {
        foreach (range($this->startHour, $this->finishHour) as $hour) {
            $this->actualHour = $hour;
            foreach (range($this->startMinute, self::HOURS_IN_MINUTE-1) as $minute) {
                $this->actualMinute = $minute;
                $execute($hour, $minute);
                usleep(self::MICROSECONDS * 1000);
            }
        }
    }
}