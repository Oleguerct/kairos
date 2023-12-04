<?php

namespace App\Entity\Condition;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\QueryBuilder;

#[ORM\Entity()]
class MinTemperatureCondition extends Condition
{

    #[ORM\Column]
    private ?int $minTemperature = null;

    public function __construct()
    {
        $this->appliesTo = self::APPLIES_TO_ALL_DAYS;
    }

    public function getMinTemperature(): ?int
    {
        return $this->minTemperature;
    }

    public function setMinTemperature(int $minTemperature): static
    {
        $this->minTemperature = $minTemperature;

        return $this;
    }

    function addClauseToQueryBuilder(QueryBuilder $queryBuilder): QueryBuilder
    {
        return $queryBuilder
            ->andWhere('w.tempMin >= :tempMin')
            ->setParameter('tempMin',$this->minTemperature);
    }

}
