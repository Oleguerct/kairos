<?php


namespace App\Service;


use App\Entity\Condition\CityCondition;
use App\Entity\Condition\DateCondition;
use App\Entity\Contract;
use App\Entity\WeatherForecast;
use App\Repository\WeatherForecastRepository;
use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;

class ForecastDownloadPlanner
{

    /**
     * ForecastDownloadPlanner constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(
        private EntityManager $entityManager
    ){}

    public function getLocations()
    {
        $today = new \DateTime();
        $locationsQB = $this->entityManager->createQueryBuilder();
        $locationsQB
            ->select('ccnd.city as location')
            ->distinct()
            ->from(Contract::class, 'cnt')
            ->leftJoin(CityCondition::class, 'ccnd', 'WITH', 'cnt.id = ccnd.contract')
            ->leftJoin(DateCondition::class, 'dcnd', 'WITH', 'cnt.id = dcnd.contract')
            ->andWhere('dcnd.date > :today')
            ->orWhere($locationsQB->expr()->isNull('dcnd.date'))
            ->setParameter('today', $today)
        ;

        return $locationsQB->getQuery()->getResult();

    }

}