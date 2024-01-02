<?php


namespace App\Tests\Functional;


use App\Factory\ApiTokenFactory;
use App\Factory\ContractFactory;
use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\ResetDatabase;

class ContractResourceTest extends KernelTestCase
{
    use HasBrowser;
    use ResetDatabase;

    public function testGetCollectionOfContractsNotAuthenticatedReturn401(): void
    {
        $this->browser()->get('/api/contracts')
            ->assertStatus(401);
    }

    public function testGetCollectionOfContractsAuthenticated(): void
    {
        $token = ApiTokenFactory::createOne();
        $user = UserFactory::createOne([
            'apiTokens' => [$token]
        ]);
        ContractFactory::createMany(5, [
            'owner' => $user
        ]);
        ContractFactory::createOne();

        $result = $this->browser()->get('/api/contracts', [
            'headers' => ['Authorization' => 'Bearer '.$token->getToken()]
        ])
            ->assertStatus(200)
            ->assertJson()
            ->assertJsonMatches('"hydra:totalItems"', 5)
            ->json()
            ;

        $this->assertSame(array_keys($result->decoded()['hydra:member'][0]), [
            "@id",
            "@type",
            "condition",
            "days",
            "owner"
        ]);
    }

    public function testUnauthenticatedCantPostContract(): void
    {
        $response = $this->browser()
            ->post('/api/contracts', [
                'headers' => [
                    'Content-Type' => 'application/ld+json'
                ],
                'body' => json_encode([
                    'condition' => [
                        [
                            '@type' => 'CityCondition',
                            'city' => 'Girona',
                        ],
                    ],
                    'days' => 6,
                ]),
            ])
            ->assertStatus(401)
        ;
    }

    public function testPostContractSetCorrectOwner(): void
    {
        $token = ApiTokenFactory::createOne();
        $user = UserFactory::createOne([
            'apiTokens' => [$token]
        ]);

        $response = $this->browser()
            ->post('/api/contracts', [
                'headers' => [
                    'Content-Type' => 'application/ld+json',
                    'Authorization' => 'Bearer '.$token->getToken()
                ],
                'body' => json_encode([
                    'condition' => [
                        [
                            '@type' => 'CityCondition',
                            'city' => 'Girona',
                        ],
                    ],
                    'days' => 6,
                ]),
            ])
            ->assertStatus(201)
            ;

        $content = json_decode($response->content());
        $this->assertSame(sprintf('/api/users/%s',$user->getId()), $content->owner );
    }



}