<?php

namespace App\Factory\Condition;

use App\Entity\Condition\CityCondition;
use App\Factory\ContractFactory;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<CityCondition>
 *
 * @method        CityCondition|Proxy              create(array|callable $attributes = [])
 * @method static CityCondition|Proxy              createOne(array $attributes = [])
 * @method static CityCondition|Proxy              find(object|array|mixed $criteria)
 * @method static CityCondition|Proxy              findOrCreate(array $attributes)
 * @method static CityCondition|Proxy              first(string $sortedField = 'id')
 * @method static CityCondition|Proxy              last(string $sortedField = 'id')
 * @method static CityCondition|Proxy              random(array $attributes = [])
 * @method static CityCondition|Proxy              randomOrCreate(array $attributes = [])
 * @method static EntityRepository|RepositoryProxy repository()
 * @method static CityCondition[]|Proxy[]          all()
 * @method static CityCondition[]|Proxy[]          createMany(int $number, array|callable $attributes = [])
 * @method static CityCondition[]|Proxy[]          createSequence(iterable|callable $sequence)
 * @method static CityCondition[]|Proxy[]          findBy(array $attributes)
 * @method static CityCondition[]|Proxy[]          randomRange(int $min, int $max, array $attributes = [])
 * @method static CityCondition[]|Proxy[]          randomSet(int $number, array $attributes = [])
 */
final class CityConditionFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'appliesTo' => 'ALL_DAYS',
            'city' => self::faker()->city(),
            'contract' => ContractFactory::new(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(CityCondition $cityCondition): void {})
        ;
    }

    protected static function getClass(): string
    {
        return CityCondition::class;
    }
}
