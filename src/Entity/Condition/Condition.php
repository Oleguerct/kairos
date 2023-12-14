<?php

namespace App\Entity\Condition;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Contract;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Serializer\Annotation\DiscriminatorMap;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity()]
#[InheritanceType('SINGLE_TABLE')]
#[DiscriminatorColumn(name: 'condition_type', type: 'string')]
#[DiscriminatorMap(typeProperty: '@type', mapping: [
    'CityCondition' => CityCondition::class,
    'DateCondition' => DateCondition::class,
    'DateRangeCondition' => DateRangeCondition::class,
    'MaxTemperatureCondition' => MaxTemperatureCondition::class,
    'MinTemperatureCondition' => MinTemperatureCondition::class,
    'WeekDayCondition' => WeekDayCondition::class
])]
#[ApiResource(
    normalizationContext: ['groups' => ['condition:read']],
    denormalizationContext: ['groups' => ['condition:write']],
)]
abstract class Condition
{

    // Allowed criterion types
    const APPLIES_TO_ALL_DAYS = 'ALL_DAYS';
    const APPLIES_TO_FIRST_DAY = 'FIRST_DAY';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'condition')]
    #[Groups(['contract:write'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Contract $contract = null;

    #[ORM\Column(length: 15)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['contract:read'])]
    protected ?string $appliesTo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Must return the same QueryBuilder adding a criterion where clause.
     * @param QueryBuilder $queryBuilder
     * @return QueryBuilder
     */
    abstract function addClauseToQueryBuilder(QueryBuilder $queryBuilder): QueryBuilder;

    public function getContract(): ?Contract
    {
        return $this->contract;
    }

    public function setContract(?Contract $contract): static
    {
        $this->contract = $contract;

        return $this;
    }

    public function getAppliesTo(): ?string
    {
        return $this->appliesTo;
    }

    public function setAppliesTo(string $criteriaType): static
    {
        $this->appliesTo = $criteriaType;

        return $this;
    }

}
