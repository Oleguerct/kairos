<?php

namespace App\Entity\Condition;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity()]
#[ApiResource(
    normalizationContext: ['groups' => ['condition:read']],
    denormalizationContext: ['groups' => ['condition:write']],
)]
class DateCondition extends Condition
{

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['contract:read', 'contract:write'])]
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
