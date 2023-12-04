<?php

namespace App\Entity;

use App\Repository\OpportunityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OpportunityRepository::class)]
class Opportunity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fromDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $toDate = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'], inversedBy: 'opportunities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Contract $contract = null;

    /**
     * Opportunity constructor.
     * @param \DateTimeInterface $fromDate
     * @param \DateTimeInterface $toDate
     * @param Contract $criteriaPack
     */
    public function __construct(\DateTimeInterface $fromDate, \DateTimeInterface $toDate, Contract $criteriaPack)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->contract = $criteriaPack;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFromDate(): ?\DateTimeInterface
    {
        return $this->fromDate;
    }

    public function setFromDate(\DateTimeInterface $fromDate): static
    {
        $this->fromDate = $fromDate;

        return $this;
    }

    public function getToDate(): ?\DateTimeInterface
    {
        return $this->toDate;
    }

    public function setToDate(\DateTimeInterface $toDate): static
    {
        $this->toDate = $toDate;

        return $this;
    }

    public function getContract(): ?Contract
    {
        return $this->contract;
    }

    public function setContract(?Contract $contract): static
    {
        $this->contract = $contract;

        return $this;
    }
}
