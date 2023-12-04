<?php


namespace App\Tests\Functional\Service;

use App\Entity\Condition\CityCondition;
use App\Entity\Condition\DateCondition;
use App\Entity\Condition\MaxTemperatureCondition;
use App\Entity\Condition\MinTemperatureCondition;
use App\Entity\CriteriaPack_backup;
use App\Entity\CriterionGroupCollection;
use App\Factory\WeatherForecastFactory;
use App\Service\OpportunityFinder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OpportunityFinderTest extends KernelTestCase
{
    public function testGetOpportunitiesWorksFine(){

        self::bootKernel();

        $container = static::getContainer();

        /** @var OpportunityFinder $opportunityFinder */
        $opportunityFinder = $container->get(OpportunityFinder::class);
        $entityManager = $container->get(EntityManagerInterface::class);
        $forecastFactory = $container->get(WeatherForecastFactory::class);

        // Populate forecast
        $this->populateForecast($forecastFactory);

        $maxTCriterion = new MaxTemperatureCondition();
        $maxTCriterion->setMaxTemperature(30);

        $minTCriterion = new MinTemperatureCondition();
        $minTCriterion->setMinTemperature(10);

        $cityCriterion = new CityCondition();
        $cityCriterion->setCity('Bordils');

        $dateCriterion = new DateCondition();
        $dateCriterion->setDate(new \DateTime('2023-12-2'));

        $criterionGroup = new CriteriaPack_backup();
        $criterionGroup->addCriterion($maxTCriterion);
        $criterionGroup->addCriterion($minTCriterion);
        $criterionGroup->addCriterion($cityCriterion);
        $criterionGroup->addCriterion($dateCriterion);

        $criterionGroupCollection = new CriterionGroupCollection();
        $criterionGroupCollection->addCriterionGroup($criterionGroup);

        $entityManager->persist($criterionGroupCollection);

        $opportunityFinder->getMatchingForecast();

        $this->assertIsArray($opportunityFinder->getMatchingForecast());
        $this->assertCount(0, $opportunityFinder->getMatchingForecast());
    }

    private function populateForecast(WeatherForecastFactory $forecastFactory){
        $forecastFactory::createMany(
            15,
            static function(int $i) {
                $i--; // Set from 0 to 15
                return
                    [
                        'day' => new \DateTime('2023-12-1 +'.$i.' day'),
                        'location' => 'Bordils',
                        'tempMin' => 10+$i,
                        'tempMax' => 20+$i
                    ];
            }
        );
    }

}