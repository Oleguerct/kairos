<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Contract;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

#[AsDecorator('api_platform.doctrine.orm.state.persist_processor')]
class ContractSetOwnerProcessor implements ProcessorInterface
{
    /**
     * ContractSetOwnerProcessor constructor.
     */
    public function __construct(private ProcessorInterface $processor, private Security $security){}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if($data instanceof Contract && $data->getOwner() === null && $this->security->getUser()){
            $data->setOwner($this->security->getUser());
        }
        return $this->processor->process($data, $operation, $uriVariables, $context);
    }
}
