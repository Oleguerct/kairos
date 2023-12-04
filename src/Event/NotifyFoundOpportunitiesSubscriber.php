<?php


namespace App\Event;


use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NotifyFoundOpportunitiesSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [
            OpportunitiesFoundEvent::class => 'notifyOpportunity',
        ];
    }

    public function notifyOpportunity(OpportunitiesFoundEvent $event){
        $io = new SymfonyStyle(new ArrayInput([]), new ConsoleOutput());
        $io->note('HOOOLAAA');
    }
}