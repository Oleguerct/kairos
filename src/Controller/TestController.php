<?php


namespace App\Controller;

use App\Entity\Condition\DateRangeCondition;
use App\Entity\Condition\MaxTemperatureCondition;
use App\Entity\Condition\WeekDayCondition;
use App\Entity\Contract;
use App\Service\MatchingDateRangeFinder;
use App\Service\OpportunityGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/')]
    public function main(EntityManagerInterface $entityManager, MatchingDateRangeFinder $dateRangeFinder, OpportunityGenerator $opportunityGenerator ):Response
    {

        $contractRepo = $entityManager->getRepository(Contract::class);
        $contract = $contractRepo->findOneBy([]);

//        $weekDayCondition = new WeekDayCondition();
//        $weekDayCondition->setWeekDay(1);
//
//        $maxTempCondition = new MaxTemperatureCondition();
//        $maxTempCondition->setMaxTemperature(33);
//
//        $dateRangeCondition = new DateRangeCondition();
//        $dateRangeCondition->setMinDate(new \DateTime('2023-12-01'));
//        $dateRangeCondition->setMaxDate(new \DateTime('2023-12-14'));
//
//        $conditions = [
//            //$maxTempCondition,
//            $weekDayCondition,
//            $dateRangeCondition
//        ];
//
//        $contract = new Contract();
//        $contract->addConditions($conditions);
//        $contract->setDays(3);


        $opportunities = $opportunityGenerator->getOpportunities($contract);
        foreach ($opportunities as $opportunity){
            $entityManager->persist($opportunity);
        }
        $entityManager->flush();


        return $this->render('base.html.twig');
    }
}