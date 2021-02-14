<?php

declare(strict_types=1);

namespace App\Simulator\UI\Cli\Command;

use App\Simulator\Application\Command\Building\CreateCommand;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;
use Symfony\Component\Messenger\HandleTrait;

class CreateBuildingCommand extends Command
{
    use HandleTrait;

    protected function configure(): void
    {
        $this->setName('building:create');
    }

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
        parent::__construct();
    }

    /**
     * @throws Exception
     * @throws Throwable
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->handle(new CreateCommand('Building1', 4));
        return 1;
    }
}
