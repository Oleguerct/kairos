<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:get-forecast',
    description: 'Add a short description for your command',
)]
class GetForecastCommand extends Command
{
    public function __construct()
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
        // TODO: Implement method
        $io = new SymfonyStyle($input, $output);

        $io->success('Command works!');

        return Command::SUCCESS;
    }
}
