<?php


namespace App\Event;


use App\Entity\CriterionGroupCollection;

class OpportunitiesFoundEvent
{

    /**
     * OpportunitiesFoundEvent constructor.
     * @param CriterionGroupCollection[] $criteriaGCArray
     */
    public function __construct(public array $criteriaGCArray)
    {

    }
}