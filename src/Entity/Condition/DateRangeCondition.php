<?php

namespace App\Entity\Condition;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity()]
#[ApiResource(
    operations:[],
    normalizationContext: ['groups' => ['condition:read']],
    denormalizationContext: ['groups' => ['condition:write']],
)]
class DateRangeCondition extends Condition
{

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['contract:read', 'contract:write'])]
    private ?\DateTimeInterface $minDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['contract:read', 'contract:write'])]
    private ?\DateTimeInterface $maxDate = null;

    public function __construct()
    {
        $this->appliesTo = self::APPLIES_TO_ALL_DAYS;
    }

    public function getMinDate(): ?\DateTimeInterface
    {
        return $this->minDate;
    }

    public function setMinDate(\DateTimeInterface $minDate): static
    {
        $this->minDate = $minDate;

        return $this;
    }

    public function getMaxDate(): ?\DateTimeInterface
    {
        return $this->maxDate;
    }

    public function setMaxDate(\DateTimeInterface $maxDate): static
    {
        $this->maxDate = $maxDate;

        return $this;
    }

    function addClauseToQueryBuilder(QueryBuilder $queryBuilder): QueryBuilder
    {
        return $queryBuilder
            ->andWhere($queryBuilder->expr()->between('w.day',':minDate',':maxDate'))
            ->setParameter('minDate', $this->minDate)
            ->setParameter('maxDate', $this->maxDate);
    }
}
