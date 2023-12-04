<?php

namespace App\Entity\Condition;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\QueryBuilder;

#[ORM\Entity()]
class WeekDayCondition extends Condition
{

    #[ORM\Column]
    private ?int $weekDay = null;

    public function __construct()
    {
        $this->appliesTo = self::APPLIES_TO_FIRST_DAY;
    }

    public function getWeekDay(): ?int
    {
        return $this->weekDay;
    }

    public function setWeekDay(int $weekDay): static
    {
        $this->weekDay = $weekDay;

        return $this;
    }

    public function addClauseToQueryBuilder(QueryBuilder $queryBuilder): QueryBuilder
    {
        return $queryBuilder->andWhere('EXTRACT(DOW FROM t1.day) = :weekDay')
            ->setParameter(':weekDay', $this->weekDay);
    }

}
