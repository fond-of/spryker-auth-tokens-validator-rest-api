<?php

declare(strict_types=1);

namespace FondOfSpryker\Glue\CheckoutRestApi;

use FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface;
use FondOfSpryker\Glue\CheckoutRestApi\Processor\Checkout\CheckoutProcessor;
use FondOfSpryker\Glue\CheckoutRestApi\Processor\Checkout\CheckoutProcessorInterface;
use FondOfSpryker\Glue\CheckoutRestApi\Processor\Validation\RestApiError;
use FondOfSpryker\Glue\CheckoutRestApi\Processor\Validation\RestApiErrorInterface;
use Spryker\Client\CartsRestApi\CartsRestApiClientInterface;
use Spryker\Glue\CheckoutRestApi\CheckoutRestApiFactory as SprykerCheckoutRestApiFactory;

/**
 * @method \FondOfSpryker\Client\CheckoutRestApi\CheckoutRestApiClientInterface getClient()
 * @method \FondOfSpryker\Glue\CheckoutRestApi\CheckoutRestApiConfig getConfig()
 */
class AuthValidatorRestApiFactory extends SprykerCheckoutRestApiFactory
{
    /**
     * @return \FondOfSpryker\Glue\CheckoutRestApi\Processor\Checkout\CheckoutProcessorInterface
     */
    public function createFondOfCheckoutProcessor(): CheckoutProcessorInterface
    {
        return new CheckoutProcessor(
            $this->getClient(),
            $this->getResourceBuilder(),
            $this->createCheckoutRequestAttributesExpander(),
            $this->createCheckoutRequestValidator(),
            $this->createRestCheckoutErrorMapper(),
            $this->createCheckoutResponseMapper(),
            $this->getCompanyUserRestApiClient(),
            $this->getCartsRestApiClient(),
            $this->getRestApiError()
        );
    }

    /**
     * @return \FondOfSpryker\Glue\CheckoutRestApi\Processor\Validation\RestApiErrorInterface
     */
    protected function getRestApiError(): RestApiErrorInterface
    {
        return new RestApiError();
    }

    /**
     * @return \Spryker\Client\CartsRestApi\CartsRestApiClientInterface
     */
    protected function getCartsRestApiClient(): CartsRestApiClientInterface
    {
        return $this->getProvidedDependency(CheckoutRestApiDependencyProvider::CLIENT_REST_CARTS);
    }

    /**
     * @return \FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface
     */
    protected function getCompanyUserRestApiClient(): CompanyUsersRestApiClientInterface
    {
        return $this->getProvidedDependency(CheckoutRestApiDependencyProvider::CLIENT_REST_COMPANY_USER);
    }
}