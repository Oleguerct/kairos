<?php


namespace App\Security;


use App\Repository\ApiTokenRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

class ApiTokenHandler implements AccessTokenHandlerInterface
{


    /**
     * ApiTokenHandler constructor.
     * @param ApiTokenRepository $apiTokenRepository
     */
    public function __construct(
        private ApiTokenRepository $apiTokenRepository,
    )
    {
    }

    public function getUserBadgeFrom(string $accessToken): UserBadge
    {

        $token = $this->apiTokenRepository->findOneBy(['token' => $accessToken]);

        if (!$token) {
            throw new BadCredentialsException();
        }

        if (!$token->isValid()) {
            throw new CustomUserMessageAuthenticationException('Token expired');
        }

        return new UserBadge($token->getOwnedBy()->getUserIdentifier());
    }
}