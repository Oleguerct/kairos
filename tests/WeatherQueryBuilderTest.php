<?php

namespace App\Tests;

use App\Entity\WeatherForecast;
use App\Factory\WeatherForecastFactory;
use App\UseCase\WeatherQueryBuilder\WeatherQueryBuilder;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;
use function Zenstruck\Foundry\faker;
use \Doctrine\Persistence\ObjectManager;

class WeatherQueryBuilderTest extends KernelTestCase
{
    use ResetDatabase, Factories;

    private ObjectManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

//    public function testSomething(): void
//    {
//        $kernel = self::bootKernel();
//
//        $this->assertSame('test', $kernel->getEnvironment());
//        // $routerService = static::getContainer()->get('router');
//        // $myCustomService = static::getContainer()->get(CustomService::class);
//    }


    public function testInitReturnAWeatherQueryBuilder(): void
    {
        WeatherForecastFactory::new()->createOne();
        $queryBuilder = new WeatherQueryBuilder($this->entityManager);
        self::assertInstanceOf(WeatherQueryBuilder::class, $queryBuilder->init());
    }

    public function testGetResultsReturnResults(): void
    {
        WeatherForecastFactory::createMany(5);
        $queryBuilder = new WeatherQueryBuilder($this->entityManager);
        $queryBuilder->init();
        self::assertCount(5,$queryBuilder->getResults());
        self::assertContainsOnlyInstancesOf(WeatherForecast::class,$queryBuilder->getResults());
    }

    public function testFilterByLocationOnlyMatchLocations(): void
    {
        WeatherForecastFactory::new()->createOne([
            'location' => 'Bordils'
        ]);
        WeatherForecastFactory::new()->createOne([
            'location' => 'Girona'
        ]);
        WeatherForecastFactory::new()->createOne([
            'location' => 'Barcelona'
        ]);

        $wqb = new WeatherQueryBuilder($this->entityManager);
        $wqb->init();
        ;
        self::assertCount(1, $wqb->setLocation('Bordils')->getResults());
        self::assertCount(0, $wqb->setLocation('Sabadell')->getResults());
    }

    public function testFilterByDateReturOnlyMatchDates(): void
    {
        WeatherForecastFactory::new()->createOne([
            'day' => new \DateTime('2024/01/02')
        ]);
        WeatherForecastFactory::new()->createOne([
            'day' => new \DateTime('2023/10/10')
        ]);

        $dayExistQueryBuilder = new WeatherQueryBuilder($this->entityManager);
        $dayNotExistQueryBuilder = new WeatherQueryBuilder($this->entityManager);
        self::assertCount(1, $dayExistQueryBuilder->init()->setDate(new \DateTime('2023/10/10'))->getResults());
        self::assertCount(0, $dayNotExistQueryBuilder->init()->setDate(new \DateTime('2024/10/10'))->getResults());

    }
}
