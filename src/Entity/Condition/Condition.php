<?php

namespace App\Entity\Condition;

use App\Entity\Contract;
use App\Repository\CriterionRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\QueryBuilder;

#[ORM\Entity()]
#[InheritanceType('JOINED')]
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
    #[ORM\JoinColumn(nullable: false)]
    private ?Contract $contract = null;

    #[ORM\Column(length: 15)]
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
