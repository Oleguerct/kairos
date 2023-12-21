<?php

namespace App\Entity\Condition;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity()]
#[ApiResource(
    operations:[],
    normalizationContext: ['groups' => ['condition:read']],
    denormalizationContext: ['groups' => ['condition:write']],
)]
class WeekDayCondition extends Condition
{

    #[ORM\Column]
    #[Groups(['contract:read', 'contract:write'])]
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
