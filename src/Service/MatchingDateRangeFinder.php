<?php


namespace App\Service;


use App\Entity\Condition\Condition;
use App\Entity\Contract;
use App\Entity\Opportunity;
use App\Entity\WeatherForecast;
use App\Repository\WeatherForecastRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;

class MatchingDateRangeFinder
{
    /**
     * OpportunityFinder constructor.
     * @param WeatherForecastRepository $forecastRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        private WeatherForecastRepository $forecastRepository,
        private EntityManagerInterface $entityManager
    )
    {
    }

    public function findDateRangesMatchingConditions(Contract $contract){

        // Get data from $criteriaPack
        $days = $contract->getDays();
        $allDaysCriteria = $contract->getConditionsForAllDays();
        $firstDayCriteria = $contract->getConditionsForFirstDay();

        // Get days matching criteria
        $availableDaysIds = $this->forecastRepository->getIDsForMatchingCriteria($allDaysCriteria);

        //Setup main query
        $mainQueryQB = $this->setupMainQuery($availableDaysIds, $firstDayCriteria, $days);

        return $mainQueryQB->getQuery()->getResult();

    }

    /**
     * @param int[] $availableDaysIds
     * @param Condition[] $firstDayCriteria
     * @param int $days
     * @return QueryBuilder
     */
    private function setupMainQuery(array $availableDaysIds, array $firstDayCriteria, int $days): QueryBuilder
    {
        // Init query
        $mainQueryQB = $this->entityManager->createQueryBuilder();

        $mainQueryQB
            ->select('t1.day AS first_day')
            ->from(WeatherForecast::class,'t1')
            ->andWhere($mainQueryQB->expr()->in('t1.id',$availableDaysIds))
        ;

        for ($i = 2; $i <= $days; $i++){

            /* Self join to group dates  */
            $joinExpresion = sprintf("t1.day = DATE_SUB(t%d.day, %d, 'DAY')", $i, $i-1);
            $mainQueryQB
                ->join(WeatherForecast::class, sprintf('t%d', $i), Expr\Join::WITH, $joinExpresion)
                ->andWhere($mainQueryQB->expr()->in("t".$i.".id",$availableDaysIds));

            /* Add last_day column */
            if($i == $days){
                $selectClause = sprintf('t%d.day AS last_day', $i);
                $mainQueryQB->addSelect($selectClause);
            }

        }

        // Add first day criteria clauses
        foreach ($firstDayCriteria as $criterion){
            $criterion->addClauseToQueryBuilder($mainQueryQB);
        }

        return $mainQueryQB;
    }



}