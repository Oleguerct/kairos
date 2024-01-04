<?php


namespace App\Tests\Functional\Service;


use App\Factory\Condition\CityConditionFactory;
use App\Factory\Condition\DateConditionFactory;
use App\Factory\ContractFactory;
use App\Service\ForecastDownloadPlanner;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Formatter;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ForecastDownloadPlannerTest extends KernelTestCase
{

    private ForecastDownloadPlanner $forecastDownloadPlanner;
    private EntityManagerInterface $entityManager;
    private CityConditionFactory $cityConditionFactory;
    private ContractFactory $contractFactory;
    private DateConditionFactory $dateConditionFactory;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = self::getContainer()->get('doctrine')->getManager();
        $this->forecastDownloadPlanner = new ForecastDownloadPlanner($this->entityManager);
        $this->cityConditionFactory = self::getContainer()->get(CityConditionFactory::class);
        $this->contractFactory = self::getContainer()->get(ContractFactory::class);
        $this->dateConditionFactory = self::getContainer()->get(DateConditionFactory::class);

    }

    public function testGetLocationsReturnEmptyArrayIfNoResults(): void
    {
        $result = $this->forecastDownloadPlanner->getLocations();
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function testGetLocationsReturnAllLocationsNotLinkedToADate(): void
    {
        $contract = $this->contractFactory->createOne();
        $this->cityConditionFactory->createOne([
            'contract' => $contract,
            'city' => 'Girona'
        ]);

        $contract2 = $this->contractFactory->createOne();
        $this->cityConditionFactory->createOne([
            'contract' => $contract2,
            'city' => 'Barcelona'
        ]);
        $result = $this->forecastDownloadPlanner->getLocations();
        $this->assertIsArray($result);
        $this->assertCount(2, $result);

    }

    public function testGetLocationsReturnOnceDuplicatedLocations(): void
    {
        $contract = $this->contractFactory->createOne();
        $this->cityConditionFactory->createOne([
            'contract' => $contract,
            'city' => 'Girona'
        ]);

        $contract2 = $this->contractFactory->createOne();
        $this->cityConditionFactory->createOne([
            'contract' => $contract2,
            'city' => 'Barcelona'
        ]);

        $contract3 = $this->contractFactory->createOne();
        $this->cityConditionFactory->createOne([
            'contract' => $contract3,
            'city' => 'Girona'
        ]);

        $result = $this->forecastDownloadPlanner->getLocations();
        $this->assertIsArray($result);
        $this->assertCount(2, $result);

    }

    public function testGetLocationsDontReturnLocationsLinkedToPastDates(): void
    {
        $pastDate = (new \DateTime())->modify('-1 day');

        $contract = $this->contractFactory->createOne();
        $this->cityConditionFactory->createOne([
            'contract' => $contract,
            'city' => 'Girona'
        ]);

        $this->dateConditionFactory->createOne([
            'contract' => $contract,
            'date' => $pastDate
        ]);

        $contract2 = $this->contractFactory->createOne();
        $this->cityConditionFactory->createOne([
            'contract' => $contract2,
            'city' => 'Barcelona'
        ]);
        $result = $this->forecastDownloadPlanner->getLocations();

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertSame('Barcelona', $result[0]['location']);
    }

    public function testGetLocationsDontReturnEmptyLocations(): void
    {
        $contract = $this->contractFactory->createOne();
        $this->cityConditionFactory->createOne([
            'contract' => $contract,
            'city' => 'Girona'
        ]);

        $contract2 = $this->contractFactory->createOne();
        $this->cityConditionFactory->createOne([
            'contract' => $contract2,
            'city' => 'Barcelona'
        ]);

        $this->contractFactory->createOne();

        $result = $this->forecastDownloadPlanner->getLocations();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);

    }

}