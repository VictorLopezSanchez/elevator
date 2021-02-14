<?php

namespace App\Simulator\UI\Cli\Command\Helper;

use Symfony\Component\Console\Output\OutputInterface;

class ConsoleDebug
{
    public function __construct(OutputInterface $output)
    {
        $this->clock = $output->section();
    }

    public function refresh(Clock $clock)
    {
        $this->clock->overwrite(
            ($clock->actualHour < 10 ? "0" . $clock->actualHour : $clock->actualHour)  .
            ':' .
            ($clock->actualMinute < 10 ? "0" . $clock->actualMinute : $clock->actualMinute)
        );
    }
}
