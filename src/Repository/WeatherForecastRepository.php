<?php

namespace App\Repository;

use App\Entity\Condition\Condition;
use App\Entity\WeatherForecast;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WeatherForecast>
 *
 * @method WeatherForecast|null find($id, $lockMode = null, $lockVersion = null)
 * @method WeatherForecast|null findOneBy(array $criteria, array $orderBy = null)
 * @method WeatherForecast[]    findAll()
 * @method WeatherForecast[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeatherForecastRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WeatherForecast::class);
    }

    /**
     * @param Condition[] $criteria
     */
    public function getQueryBuilderMatchingCriteria(array $criteria): QueryBuilder
    {

        $queryBuilder =  $this->createQueryBuilder('w');

        foreach ($criteria as $criterion){
            $criterion->addClauseToQueryBuilder($queryBuilder);
        }

        return $queryBuilder
            ->orderBy('w.day', 'ASC');
    }

    public function getIDsForMatchingCriteria(array $criteria): array
    {
        return $this->getQueryBuilderMatchingCriteria($criteria)
            ->select('w.id')
            ->getQuery()->getSingleColumnResult();
    }


    public function findGroups($groupNumber){
        $selectParams = ["t1.day AS day1"];
        $queryBuilder = $this->createQueryBuilder('t1');

        for ($i=2; $i<=$groupNumber; $i++){
            $selectParams[] = "t$i.day AS day$i";
            $queryBuilder->join(WeatherForecast::class, 't'.$i, 'WITH', 't'.($i - 1).'.day = DATE_SUB(t'.$i.'.day, 1, \'DAY\')');
        }

        $queryBuilder
            ->select(...$selectParams)
            ->orderBy('t1.day')
        ;

        return $queryBuilder->getQuery()->getResult();

    }

    public function findMatchingDays($daysNumber, $climaCriteria = null, $timeCriteria = null){



        return $queryBuilder->getQuery()->getResult();

    }


//    /**
//     * @return WeatherForecast[] Returns an array of WeatherForecast objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?WeatherForecast
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
