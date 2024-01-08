<?php


namespace App\MessageHandler;

use App\Message\UpdateLocationForecastMessage;
use App\Service\ForecastAPIConnection\ForecastAPIConnectionInterface;
use App\Service\ForecastUpdater;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateLocationForecastMessageHandler
{

    public function __construct(
        private LoggerInterface $logger,
        private ForecastAPIConnectionInterface $forecastAPIConnection,
        private ForecastUpdater $forecastUpdater
    ){

    }

    public function __invoke(UpdateLocationForecastMessage $message)
    {
        $forecastsDTOs = $this->forecastAPIConnection->getForecastsDTOs($message->getLocation());
        foreach ($forecastsDTOs as $forecastsDTO){
            $this->forecastUpdater->update($forecastsDTO);
        }
    }
}