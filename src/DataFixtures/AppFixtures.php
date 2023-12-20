<?php

namespace App\DataFixtures;

use App\Entity\ApiToken;
use App\Entity\Condition\CityCondition;
use App\Entity\Condition\DateCondition;
use App\Entity\Condition\WeekDayCondition;
use App\Entity\Contract;
use App\Entity\Condition\MaxTemperatureCondition;
use App\Entity\Condition\MinTemperatureCondition;
use App\Entity\Simple;
use App\Entity\User;
use App\Factory\WeatherForecastFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $maxTCriterion = new MaxTemperatureCondition();
        $maxTCriterion->setMaxTemperature(34);

        $minTCriterion = new MinTemperatureCondition();
        $minTCriterion->setMinTemperature(10);

        $cityCriterion = new CityCondition();
        $cityCriterion->setCity('Bordils');

        $cityCriterion2 = new CityCondition();
        $cityCriterion2->setCity('Girona');

        $dateCriterion = new DateCondition();
        $dateCriterion->setDate(new \DateTime('2023-12-2'));

        $weekDayCriterion = new WeekDayCondition();
        $weekDayCriterion->setWeekDay(1);

        $apiToken = new ApiToken();
        $manager->persist($apiToken);

        $user = new User();
        $user->setEmail('fake@mail.com');
        $user->setPassword('$2y$13$.HZ3/.6Ws6B.YemwU3p2NOpT4IgjMupTamKXDstU28QGsQBQ8W4Ve');
        $user->addApiToken($apiToken);
        $manager->persist($user);

        $user2 = new User();
        $user2->setEmail('fake2@mail.com');
        $user2->setPassword('$2y$13$.HZ3/.6Ws6B.YemwU3p2NOpT4IgjMupTamKXDstU28QGsQBQ8W4Ve');
        $manager->persist($user2);


        $contract = new Contract();
        $contract->setDays(3);
        $contract->setOwner($user);
        $contract->addCondition($cityCriterion);
        $manager->persist($contract);


        $contract2 = new Contract();
        $contract2->setDays(3);
        $contract2->setOwner($user2);
        $contract2->addCondition($cityCriterion2);
        $manager->persist($contract2);



        $simple = new Simple();
        $simple->setName('Joan');
        $simple->setOwner($user);
        $manager->persist($simple);

        $simple2 = new Simple();
        $simple2->setName('Joan');
        $simple2->setOwner($user2);
        $manager->persist($simple2);

        WeatherForecastFactory::createMany(
            15,
            static function(int $i) {
                return
                    [
                        'day' => new \DateTime('+'.$i.' day'),
                        'location' => 'Bordils',
                        'tempMin' => 9+$i,
                        'tempMax' => 19+$i
                    ];
            }
        );



        $manager->flush();


    }
}
