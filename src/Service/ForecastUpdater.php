<?php


namespace App\Service;


use App\Entity\WeatherForecast;
use App\Model\ForecastDTO;
use App\Repository\WeatherForecastRepository;
use Doctrine\ORM\EntityManagerInterface;

class ForecastUpdater
{
    private WeatherForecastRepository $weatherRepository;

    /**
     * ForecastUpdater constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->weatherRepository = $this->entityManager->getRepository(WeatherForecast::class);
    }

    public function update(ForecastDTO $forecastDTO): void
    {
        $forecast = $this->weatherRepository->findOneBy([
            'location' => $forecastDTO->getLocation(),
            'day' => $forecastDTO->getDay()
        ]);

        if(! $forecast instanceof WeatherForecast){
            $forecast = new WeatherForecast();
            $this->entityManager->persist($forecast);
        }

        $this->setData($forecast, $forecastDTO);
        $this->entityManager->flush();

    }

    private function setData(WeatherForecast $entity, ForecastDTO $tdo){
        $entity
            ->setLocation($tdo->getLocation())
            ->setCloudCover($tdo->getCloudCover())
            ->setDay($tdo->getDay())
            ->setHumidity($tdo->getHumidity())
            ->setPrecipProb($tdo->getPrecipProb())
            ->setTempMax($tdo->getTempMax())
            ->setTempMean($tdo->getTempMean())
            ->setTempMin($tdo->getTempMin())
            ->setUvIndex($tdo->getUvIndex())
            ->setWindSpeed($tdo->getWindSpeed());
    }

}