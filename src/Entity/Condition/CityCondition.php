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
class CityCondition extends Condition
{

    #[ORM\Column(length: 100)]
    #[Groups(['condition:read', 'condition:write', 'contract:read', 'contract:write'])]
    private ?string $city = null;

    public function __construct()
    {
        $this->appliesTo = self::APPLIES_TO_ALL_DAYS;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getWhereClause()
    {
        // TODO: Implement getWhereClause() method.
    }

    function addClauseToQueryBuilder(QueryBuilder $queryBuilder): QueryBuilder
    {
        return $queryBuilder
            ->andWhere($queryBuilder->expr()->like('w.location', ':location'))
            ->setParameter('location',$this->city);
    }
}
