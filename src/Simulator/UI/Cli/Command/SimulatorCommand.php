<?php

declare(strict_types=1);

namespace App\Simulator\UI\Cli\Command;

use App\Simulator\UI\Cli\Command\Helper\Clock;
use App\Simulator\UI\Cli\Command\Helper\ConsoleDebug;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\HandleTrait;

class SimulatorCommand extends Command
{
    use HandleTrait;

    const START_HOUR = 9;
    const FINISH_HOUR = 19;
    const BUILDING_NAME = 'Building1';

    protected function configure(): void
    {
        $this->setName('simulator:start');
    }

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
        parent::__construct();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $consoleDebug = new ConsoleDebug($output);
        $clock = new Clock(self::START_HOUR, self::FINISH_HOUR, 0);
        $messenger = $this;

        $execute = function() use ($clock, $consoleDebug, $messenger) {
            $request = $this->createRequest($clock);
            if (!empty($request)) {
                $simulator = new \App\Simulator\Application\Command\Simulator\SimulatorCommand(self::BUILDING_NAME, $request);
                $messenger->handle($simulator);
            }

            $consoleDebug->refresh($clock);
        };

        $clock($execute);
        return Command::SUCCESS;

    }

    private function createRequest(Clock $clock): array
    {
        $request = [];
        if ($clock->actualMinute % 5 == 0 &&
            $clock->actualHour >= 9 &&
            $clock->actualHour <= 11 &&
            ($clock->actualHour == 11 ? $clock->actualMinute == 0 : true))
        {
            $request[] = [
                'hour' => $clock->actualHour,
                'minutes' => $clock->actualMinute,
                'from' => 0,
                'to' => 2
            ];
        }

        if ($clock->actualMinute % 5 == 0 &&
            $clock->actualHour >= 9 &&
            $clock->actualHour <= 11 &&
            ($clock->actualHour == 11 ? $clock->actualMinute == 0 : true))
        {
            $request[] = [
                'hour' => $clock->actualHour,
                'minutes' => $clock->actualMinute,
                'from' => 0,
                'to' => 3
            ];
        }

        if ($clock->actualMinute % 10 == 0 &&
            $clock->actualHour >= 9 &&
            $clock->actualHour <= 10 &&
            ($clock->actualHour == 10 ? $clock->actualMinute == 0 : true))
        {
            $request[] = [
                'hour' => $clock->actualHour,
                'minutes' => $clock->actualMinute,
                'from' => 0,
                'to' => 1
            ];
        }

        if ($clock->actualMinute % 20 == 0 &&
            $clock->actualHour >= 11 &&
            $clock->actualHour <= 18 &&
            ($clock->actualHour == 18 ? $clock->actualMinute <= 20 : true)
        )
        {
            $request[] = [
                'hour' => $clock->actualHour,
                'minutes' => $clock->actualMinute,
                'from' => 0,
                'to' => rand(1,3)
            ];
        }

        if ($clock->actualMinute % 4 == 0 &&
            $clock->actualHour >= 14 &&
            $clock->actualHour < 15
        )
        {
            $request[] = [
                'hour' => $clock->actualHour,
                'minutes' => $clock->actualMinute,
                'from' => rand(1,3),
                'to' => 0
            ];
        }

        if ($clock->actualMinute % 7 == 0 &&
            $clock->actualHour >= 15 &&
            $clock->actualHour <= 16 &&
            ($clock->actualHour == 16 ? $clock->actualMinute == 0 : true)
        )
        {
            $request[] = [
                'hour' => $clock->actualHour,
                'minutes' => $clock->actualMinute,
                'from' => rand(2,3),
                'to' => 0
            ];
        }

        if ($clock->actualMinute % 7 == 0 &&
            $clock->actualHour >= 15 &&
            $clock->actualHour <= 16 &&
            ($clock->actualHour == 16 ? $clock->actualMinute == 0 : true)
        )
        {
            $request[] = [
                'hour' => $clock->actualHour,
                'minutes' => $clock->actualMinute,
                'from' => 0,
                'to' => rand(1,3)
            ];
        }

        if ($clock->actualMinute % 3 == 0 &&
            $clock->actualHour >= 18 &&
            $clock->actualHour <= 20 &&
            ($clock->actualHour == 20 ? $clock->actualMinute == 0 : true)
        )
        {
            $request[] = [
                'hour' => $clock->actualHour,
                'minutes' => $clock->actualMinute,
                'from' => rand(1,3),
                'to' => 0
            ];
        }

        return $request;
    }
}
