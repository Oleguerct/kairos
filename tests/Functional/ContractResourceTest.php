<?php


namespace App\Tests\Functional;


use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\ResetDatabase;

class ContractResourceTest extends KernelTestCase
{
    use HasBrowser;
    use ResetDatabase;

    public function testGetCollectionOfContracts(): void
    {
        $this->browser()->get('/api/contracts', [
            //'headers' => ['Authorization' => 'Bearer tcp_b1b21cc477014695eb3f21680b9f4d8129340c876064f6ecf5a299eb5542eb81']
        ])->dump()
            ->assertJson()
        ;
    }

}