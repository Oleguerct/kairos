<?php

namespace App\Entity\Condition;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\QueryBuilder;

#[ORM\Entity()]
class DateCondition extends Condition
{

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    public function __construct()
    {
        $this->appliesTo = self::APPLIES_TO_ALL_DAYS;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    function addClauseToQueryBuilder(QueryBuilder $queryBuilder): QueryBuilder
    {
        return $queryBuilder
            ->andWhere('w.day = :day')
            ->setParameter('day',$this->date);
    }
}
