<?php

namespace App\Tests\Functional\Service;

use App\Entity\WeatherForecast;
use App\Factory\WeatherForecastFactory;
use App\Model\ForecastDTO;
use App\Repository\WeatherForecastRepository;
use App\Service\ForecastUpdater;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ForecastUpdaterTest extends KernelTestCase
{

    private ?WeatherForecastFactory $forecastFactory;
    private EntityManagerInterface $entityManager;
    private WeatherForecastRepository $forecastRepository;
    /**
     * @var ForecastUpdater
     */
    private ForecastUpdater $forecastUpdater;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = self::getContainer()->get('doctrine')->getManager();
        $this->forecastRepository = $this->entityManager->getRepository(WeatherForecast::class);
        $this->forecastFactory = self::getContainer()->get(WeatherForecastFactory::class);
        $this->forecastUpdater = new ForecastUpdater($this->entityManager);
    }

    public function testCreateNotExistingForecast(): void
    {
        assert($this->forecastRepository instanceof  WeatherForecastRepository);

        $result = $this->forecastRepository->findAll();
        $this->assertCount(0, $result);

        $dto = new ForecastDTO(
            location: 'Girona',
            tempMax: 25,
            tempMin: 10,
            tempMean: 19,
            humidity: 1,
            precipProb: 2,
            windSpeed:12,
            cloudCover:1,
            uvIndex:3,
            day: new \DateTime()
        );

        $this->forecastUpdater->update($dto);

        $result = $this->forecastRepository->findAll();

        $this->assertCount(1, $result);

    }

    public function testReplaceExistingForecast(): void
    {

        $forecastEntity = $this->forecastFactory->createOne([
            'tempMax' => 20
        ]);
        $result = $this->forecastRepository->findAll();
        $this->assertCount(1, $result);

        $tdo = new ForecastDTO(
            location: $forecastEntity->getLocation(),
            tempMax: 30.5,
            tempMin: $forecastEntity->getTempMin(),
            tempMean: $forecastEntity->getTempMean(),
            humidity: $forecastEntity->getHumidity(),
            precipProb: $forecastEntity->getPrecipProb(),
            windSpeed: $forecastEntity->getWindSpeed(),
            cloudCover: $forecastEntity->getCloudCover(),
            uvIndex: $forecastEntity->getUvIndex(),
            day: $forecastEntity->getDay()
        );

        $this->forecastUpdater->update($tdo);

        $all = $this->forecastRepository->findAll();
        $this->assertCount(1, $all);
        $persistedEntity = $this->forecastRepository->findOneBy([]);
        $this->assertSame(30.5, $persistedEntity->getTempMax());

    }
}
