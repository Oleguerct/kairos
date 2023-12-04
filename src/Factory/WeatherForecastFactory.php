<?php

namespace App\Factory;

use App\Entity\WeatherForecast;
use App\Repository\WeatherForecastRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<WeatherForecast>
 *
 * @method        WeatherForecast|Proxy                     create(array|callable $attributes = [])
 * @method static WeatherForecast|Proxy                     createOne(array $attributes = [])
 * @method static WeatherForecast|Proxy                     find(object|array|mixed $criteria)
 * @method static WeatherForecast|Proxy                     findOrCreate(array $attributes)
 * @method static WeatherForecast|Proxy                     first(string $sortedField = 'id')
 * @method static WeatherForecast|Proxy                     last(string $sortedField = 'id')
 * @method static WeatherForecast|Proxy                     random(array $attributes = [])
 * @method static WeatherForecast|Proxy                     randomOrCreate(array $attributes = [])
 * @method static WeatherForecastRepository|RepositoryProxy repository()
 * @method static WeatherForecast[]|Proxy[]                 all()
 * @method static WeatherForecast[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static WeatherForecast[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static WeatherForecast[]|Proxy[]                 findBy(array $attributes)
 * @method static WeatherForecast[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static WeatherForecast[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class WeatherForecastFactory extends ModelFactory
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
     */
    protected function getDefaults(): array
    {
        $tMin = self::faker()->randomFloat(1,-10, 25);
        $tMax = self::faker()->randomFloat(1,$tMin,40);
        $tMean = self::faker()->randomFloat(1,$tMin, $tMax);

        return [
            'cloudCover' => self::faker()->randomFloat(1,0,100),
            'day' => self::faker()->dateTimeBetween('now', '+15 days'),
            'humidity' => self::faker()->randomFloat(0,0,100),
            'location' => self::faker()->realTextBetween(3,10),
            'precipProb' => self::faker()->randomFloat(0,100),
            'tempMax' => $tMax,
            'tempMean' => $tMean,
            'tempMin' => $tMin,
            'uvIndex' => self::faker()->numberBetween(0,5),
            'windSpeed' => self::faker()->numberBetween(0,70),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(WeatherForecast $weatherForecast): void {})
        ;
    }

    protected static function getClass(): string
    {
        return WeatherForecast::class;
    }
}
