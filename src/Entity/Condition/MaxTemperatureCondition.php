<?php

namespace App\Entity\Condition;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\QueryBuilder;

#[ORM\Entity()]
class MaxTemperatureCondition extends Condition
{

    #[ORM\Column]
    private ?int $maxTemperature = null;

    public function __construct()
    {
        $this->appliesTo = self::APPLIES_TO_ALL_DAYS;
    }

    public function getMaxTemperature(): ?int
    {
        return $this->maxTemperature;
    }

    public function setMaxTemperature(int $maxTemperature): static
    {
        $this->maxTemperature = $maxTemperature;

        return $this;
    }

    function addClauseToQueryBuilder(QueryBuilder $queryBuilder): QueryBuilder
    {
        return $queryBuilder
            ->andWhere('w.tempMax <= :tempMax')
            ->setParameter('tempMax',$this->maxTemperature);
    }
}
