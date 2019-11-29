<?php

declare(strict_types=1);

namespace FondOfSpryker\Glue\AuthTokensValidatorRestApi\Plugin;

use FondOfSpryker\Glue\AuthTokensValidatorRestApi\AuthTokensValidatorRestApiConfig;
use Generated\Shared\Transfer\RestAccessTokensAttributesTransfer;
use Spryker\Glue\AuthRestApi\AuthRestApiConfig;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRoutePluginInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceWithParentPluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

class AuthTokensValidatorResourceRoutePlugin extends AbstractPlugin implements ResourceRoutePluginInterface, ResourceWithParentPluginInterface
{
    /**
     * @param \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface $resourceRouteCollection
     *
     * @return \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    public function configure(ResourceRouteCollectionInterface $resourceRouteCollection): ResourceRouteCollectionInterface
    {
        $resourceRouteCollection
            ->addGet('get', false);

        return $resourceRouteCollection;
    }

    /**
     * @return string
     */
    public function getResourceType(): string
    {
        return AuthTokensValidatorRestApiConfig::RESOURCE_ACCESS_TOKENS_VERIFY;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
         return AuthTokensValidatorRestApiConfig::CONTROLLER_AUTH_TOKENS_VALIDATOR;
    }

    /**
     * @return string
     */
    public function getResourceAttributesClassName(): string
    {
        return RestAccessTokensAttributesTransfer::class;
    }

    /**
     * @return string
     */
    public function getParentResourceType(): string
    {
        return AuthRestApiConfig::RESOURCE_ACCESS_TOKENS;
    }
}
