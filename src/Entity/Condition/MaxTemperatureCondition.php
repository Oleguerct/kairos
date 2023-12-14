<?php

namespace App\Entity\Condition;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity()]
#[ApiResource(
    normalizationContext: ['groups' => ['condition:read']],
    denormalizationContext: ['groups' => ['condition:write']],
)]
class MaxTemperatureCondition extends Condition
{

    #[ORM\Column]
    #[Groups(['contract:read', 'contract:write'])]
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
