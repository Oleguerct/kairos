<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Condition\Condition;
use App\Repository\ContractRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ContractRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['contract:read']],
    denormalizationContext: ['groups' => ['contract:write']],
)]
class Contract
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(
        mappedBy: 'contract',
        targetEntity: Condition::class,
        cascade: ['persist', 'remove'],
        orphanRemoval: true
    )]
    #[Groups(['contract:read', 'contract:write'])]
    private Collection $condition;

    #[ORM\Column]
    #[Groups(['contract:read', 'contract:write'])]
    private ?int $days = 1;

    #[ORM\OneToMany(mappedBy: 'contract', targetEntity: Opportunity::class, orphanRemoval: true)]
    private Collection $opportunities;

    #[ORM\ManyToOne(
        cascade: ['persist', 'remove'],
        inversedBy: 'contracts'
    )]
    #[ORM\JoinColumn(nullable: false)]
//    #[Groups(['contract:read', 'contract:write'])]
    private ?User $owner = null;

    public function __construct()
    {
        $this->condition = new ArrayCollection();
        $this->opportunities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Condition>
     */
    public function getCondition(): Collection
    {
        return $this->condition;
    }

    public function addCondition(Condition $criterion): static
    {
        if (!$this->condition->contains($criterion)) {
            $this->condition->add($criterion);
            $criterion->setContract($this);
        }

        return $this;
    }

    /**
     * @param Condition[] $criteria
     * @return $this
     */
    public function addConditions(array $criteria): static
    {
        foreach ($criteria as $criterion){
            $this->addCondition($criterion);
        }
        return $this;
    }

    public function removeCondition(Condition $condition): static
    {
        if ($this->condition->removeElement($condition)) {
            // set the owning side to null (unless already changed)
            if ($condition->getContract() === $this) {
                $condition->setContract(null);
            }
        }

        return $this;
    }

    public function getDays(): ?int
    {
        return $this->days;
    }

    public function setDays(int $days): static
    {
        $this->days = $days;

        return $this;
    }


    /**
     * @return Collection<int, Opportunity>
     */
    public function getOpportunities(): Collection
    {
        return $this->opportunities;
    }

    public function addOpportunity(Opportunity $opportunity): static
    {
        if (!$this->opportunities->contains($opportunity)) {
            $this->opportunities->add($opportunity);
            $opportunity->setContract($this);
        }

        return $this;
    }

    public function removeOpportunity(Opportunity $opportunity): static
    {
        if ($this->opportunities->removeElement($opportunity)) {
            // set the owning side to null (unless already changed)
            if ($opportunity->getContract() === $this) {
                $opportunity->setContract(null);
            }
        }

        return $this;
    }

    public function getConditionsForAllDays(): array
    {
        $criteria = [];

        /** @var Condition $condition */
        foreach ($this->condition as $condition){
            if($condition->getAppliesTo() == Condition::APPLIES_TO_ALL_DAYS){
                $criteria[] = $condition;
            }
        }

        return $criteria;

    }

    public function getConditionsForFirstDay(): array
    {
        $conditions = [];

        /** @var Condition $condition */
        foreach ($this->condition as $condition){
            if($condition->getAppliesTo() == Condition::APPLIES_TO_FIRST_DAY){
                $conditions[] = $condition;
            }
        }

        return $conditions;

    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }
}
