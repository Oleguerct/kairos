<?php


namespace App\Service;


use App\Entity\Contract;
use App\Entity\Opportunity;
use Doctrine\ORM\EntityManagerInterface;

class OpportunityGenerator
{

    /**
     * OpportunityGenerator constructor.
     * @param MatchingDateRangeFinder $dateRangeFinder
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        private MatchingDateRangeFinder $dateRangeFinder,
        private EntityManagerInterface $entityManager
    )
    {
    }

    public function getOpportunities(Contract $contract): array
    {
        $results = [];
        $opportunities = $this->dateRangeFinder->findDateRangesMatchingConditions($contract);
        foreach ($opportunities as $opportunity){
            $newOpportunity = new Opportunity(
                $opportunity['first_day'],
                $opportunity['last_day'],
                $contract
            );
            $this->entityManager->persist($newOpportunity);
            $results[] = $newOpportunity;
        }
        $this->entityManager->flush();
        return $results;
    }
}