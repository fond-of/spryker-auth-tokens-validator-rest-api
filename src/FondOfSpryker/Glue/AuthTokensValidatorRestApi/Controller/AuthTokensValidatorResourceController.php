<?php

declare(strict_types=1);

namespace FondOfSpryker\Glue\AuthTokensValidatorRestApi\Controller;

use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\Controller\AbstractController;

/**
 * @method \FondOfSpryker\Glue\AuthTokensValidatorRestApi\AuthTokensValidatorRestApiFactory getFactory()
 */
class AuthTokensValidatorResourceController extends AbstractController
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function postAction(
        RestRequestInterface $restRequest
    ): RestResponseInterface {
        return $this->getFactory()
            ->createAccessTokenValidatorProcessor()
            ->validate($restRequest);
    }
}
