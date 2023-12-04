<?php

namespace App\Command;

use App\Entity\Contract;
use App\Entity\CriterionGroupCollection;
use App\Event\FightStartingEvent;
use App\Event\OpportunitiesFoundEvent;
use App\Repository\ContractRepository;
use App\Repository\CriterionGroupCollectionRepository;
use App\Service\OpportunityFinder;
use App\Service\OpportunityGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:find-for-opportunities',
    description: 'Add a short description for your command',
)]
class FindForOpportunitiesCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private OpportunityGenerator $opportunityGenerator,
        private EventDispatcherInterface $eventDispatcher)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var ContractRepository $contractRepository */
        $contractRepository = $this->entityManager->getRepository(Contract::class);
        $contracts = $contractRepository->findAll();

        foreach ($contracts as $contract){
            $opportunities = $this->opportunityGenerator->getOpportunities($contract);
            if(sizeof($opportunities) > 0){
                $this->eventDispatcher->dispatch(new OpportunitiesFoundEvent($opportunities));
            }
        }

        //$io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
