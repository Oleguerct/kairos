<?php


namespace App\MessageHandler;

use App\Message\UpdateLocationForecastMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateLocationForecastMessageHandler
{

    public function __construct(private LoggerInterface $logger)
    {
    }

    public function __invoke(UpdateLocationForecastMessage $message)
    {
        sleep(5);
        $this->logger->info($message->getLocation());
    }
}