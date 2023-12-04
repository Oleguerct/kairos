<?php


namespace App\Tests\Functional\Entity;


use App\Entity\WeatherForecast;
use App\Factory\WeatherForecastFactory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;

trait CriteriaTestTrait
{
    /** @var EntityManagerInterface $entityManager */
    protected $entityManager;
    protected QueryBuilder $queryBuilder;
    protected ContainerInterface $container;

    private function init(){

        self::bootKernel();
        $this->container = static::getContainer();

        $this->entityManager = $this->container->get(EntityManagerInterface::class);
        $this->queryBuilder = $this->getCleanQueryBuilder();

        // Populate forecast
        $forecastFactory = $this->container->get(WeatherForecastFactory::class);
        $this->populateForecast($forecastFactory);
    }

    protected function getCleanQueryBuilder(): QueryBuilder
    {
        return $this->entityManager->createQueryBuilder()->select('w')
            ->from(WeatherForecast::class, 'w');

    }

    protected function populateForecast(WeatherForecastFactory $forecastFactory){
        $forecastFactory::createMany(
            15,
            static function(int $i) {
                $i--; // Set from 0 to 15
                return
                    [
                        'day' => new \DateTime('2023-12-1 +'.$i.' day'),
                        'location' => 'Bordils',
                        'tempMin' => 10+$i,
                        'tempMax' => 20+$i
                    ];
            }
        );
    }

}