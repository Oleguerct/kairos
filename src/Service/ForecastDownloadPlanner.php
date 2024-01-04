<?php


namespace App\Service;


use App\Entity\Condition\CityCondition;
use App\Entity\Condition\DateCondition;
use App\Entity\Contract;
use Doctrine\ORM\EntityManagerInterface;
use function Doctrine\ORM\QueryBuilder;

class ForecastDownloadPlanner
{

    /**
     * ForecastDownloadPlanner constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        private EntityManagerInterface $entityManager
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
            ->andWhere($locationsQB->expr()->isNotNull('ccnd.city'))
            ->setParameter('today', $today)
        ;

        return $locationsQB->getQuery()->getResult();

    }

}