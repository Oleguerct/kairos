<?php

namespace App\Command;

use App\Message\UpdateLocationForecastMessage;
use App\Service\ForecastAPIConnection\ForecastAPIConnectionInterface;
use App\Service\ForecastDownloadPlanner;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'app:get-forecast',
    description: 'Add a short description for your command',
)]
class GetForecastCommand extends Command
{
    public function __construct(
        private ForecastDownloadPlanner $downloadPlanner,
        private ForecastAPIConnectionInterface $APIConnection,
        private MessageBusInterface $bus
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Retrieve forecast data')
            ->setHelp('Retrieve forecast data from a API and save it to the database')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        foreach ($this->downloadPlanner->getLocations() as $location){
            $this->bus->dispatch(new UpdateLocationForecastMessage($location));
        }

        $io->success('Done');
        return Command::SUCCESS;
    }


}
