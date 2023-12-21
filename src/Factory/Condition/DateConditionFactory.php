<?php

namespace App\Factory\Condition;

use App\Entity\Condition\DateCondition;
use App\Factory\ContractFactory;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<DateCondition>
 *
 * @method        DateCondition|Proxy              create(array|callable $attributes = [])
 * @method static DateCondition|Proxy              createOne(array $attributes = [])
 * @method static DateCondition|Proxy              find(object|array|mixed $criteria)
 * @method static DateCondition|Proxy              findOrCreate(array $attributes)
 * @method static DateCondition|Proxy              first(string $sortedField = 'id')
 * @method static DateCondition|Proxy              last(string $sortedField = 'id')
 * @method static DateCondition|Proxy              random(array $attributes = [])
 * @method static DateCondition|Proxy              randomOrCreate(array $attributes = [])
 * @method static EntityRepository|RepositoryProxy repository()
 * @method static DateCondition[]|Proxy[]          all()
 * @method static DateCondition[]|Proxy[]          createMany(int $number, array|callable $attributes = [])
 * @method static DateCondition[]|Proxy[]          createSequence(iterable|callable $sequence)
 * @method static DateCondition[]|Proxy[]          findBy(array $attributes)
 * @method static DateCondition[]|Proxy[]          randomRange(int $min, int $max, array $attributes = [])
 * @method static DateCondition[]|Proxy[]          randomSet(int $number, array $attributes = [])
 */
final class DateConditionFactory extends ModelFactory
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
            'contract' => ContractFactory::new(),
            'date' => self::faker()->dateTime(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(DateCondition $dateCondition): void {})
        ;
    }

    protected static function getClass(): string
    {
        return DateCondition::class;
    }
}
