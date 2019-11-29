<?php

declare(strict_types=1);

namespace FondOfSpryker\Glue\AuthTokensValidatorRestApi;

use FondOfSpryker\Glue\AuthTokensValidatorRestApi\Processor\AccessTokenValidator;
use FondOfSpryker\Glue\AuthTokensValidatorRestApi\Processor\AccessTokenValidatorInterface;
use Spryker\Client\Oauth\OauthClientInterface;
use Spryker\Glue\Kernel\AbstractFactory;

/**
 * @method \FondOfSpryker\Glue\AuthTokensValidatorRestApi\AuthTokensValidatorRestApiConfig getConfig()
 */
class AuthTokensValidatorRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfSpryker\Glue\AuthTokensValidatorRestApi\Processor\AccessTokenValidatorInterface
     */
    public function createAccessTokenValidatorProcessor(): AccessTokenValidatorInterface
    {
        return new AccessTokenValidator(
            $this->getResourceBuilder(),
            $this->getOauthClient()
        );
    }

    /**
     * @return \Spryker\Client\Oauth\OauthClientInterface
     */
    protected function getOauthClient(): OauthClientInterface
    {
        return $this->getProvidedDependency(AuthTokensValidatorApiDependencyProvider::CLIENT_OAUTH);
    }
}
