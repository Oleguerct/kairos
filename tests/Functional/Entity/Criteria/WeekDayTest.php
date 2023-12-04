<?php


namespace App\Tests\Functional\Entity\Criteria;

use App\Entity\WeatherForecast;
use App\Entity\Condition\WeekDay;
use App\Factory\WeatherForecastFactory;
use App\Tests\Functional\Entity\CriteriaTestTrait;
use App\Tests\Service\PrepareDatabase;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class WeekDayTest extends KernelTestCase
{

    use CriteriaTestTrait;

    public function testAddClauseToQueryBuilderReturnOnlySelectedDays(){

        $this->init();

        $weekDayCriterion = new WeekDay();
        $weekDayCriterion->setWeekDay(2);
        $weekDayCriterion->addClauseToQueryBuilder($this->queryBuilder);
        $this->assertCount(2, $this->queryBuilder->getQuery()->getResult());

        $this->queryBuilder = $this->getCleanQueryBuilder();
        $weekDayCriterion = new WeekDay();
        $weekDayCriterion->setWeekDay(5);
        $weekDayCriterion->addClauseToQueryBuilder($this->queryBuilder);
        $this->assertCount(3, $this->queryBuilder->getQuery()->getResult());

    }


}