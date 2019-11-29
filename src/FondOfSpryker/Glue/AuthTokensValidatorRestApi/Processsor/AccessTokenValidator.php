<?php

declare(strict_types=1);

namespace FondOfSpryker\Glue\AuthTokensValidatorRestApi\Processor;

use FondOfSpryker\Glue\AuthTokensValidatorRestApi\AuthTokensValidatorRestApiConfig;
use Generated\Shared\Transfer\OauthAccessTokenValidationRequestTransfer;
use Generated\Shared\Transfer\OauthAccessTokenValidationResponseTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Client\Oauth\OauthClientInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Symfony\Component\HttpFoundation\Response;

class AccessTokenValidator implements AccessTokenValidatorInterface
{
    /**
     * @var \Spryker\Client\Oauth\OauthClientInterface
     */
    protected $oauthClient;

    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilder;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \Spryker\Client\Oauth\OauthClientInterface $oauthClient
     */
    public function __construct(
        RestResourceBuilderInterface $restResourceBuilder,
        OauthClientInterface $oauthClient)
    {
        $this->oauthClient = $oauthClient;
        $this->restResourceBuilder = $restResourceBuilder;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function validate(RestRequestInterface $restRequest): RestResponseInterface
    {
        $response = $this->restResourceBuilder->createRestResponse();

        $authorizationToken = $restRequest->getHttpRequest()->headers->get(AuthTokensValidatorRestApiConfig::HEADER_AUTHORIZATION);
        if (!$authorizationToken) {
            return $response->addError(
                $this->createErrorMessageTransfer(
                    AuthTokensValidatorRestApiConfig::RESPONSE_DETAIL_MISSING_ACCESS_TOKEN,
                    Response::HTTP_FORBIDDEN,
                    AuthTokensValidatorRestApiConfig::RESPONSE_CODE_FORBIDDEN
                )
            );
        }

        $authAccessTokenValidationResponseTransfer = $this->validateAccessToken(
            (string) $authorizationToken
        );

        if (!$authAccessTokenValidationResponseTransfer->getIsValid()) {
            return $response->addError(
                $this->createErrorMessageTransfer(
                    AuthTokensValidatorRestApiConfig::RESPONSE_DETAIL_INVALID_ACCESS_TOKEN,
                    Response::HTTP_UNAUTHORIZED,
                    AuthTokensValidatorRestApiConfig::RESPONSE_CODE_ACCESS_CODE_INVALID
                )
            );
        }

        return $response->setStatus(200);
    }

    /**
     * @param string $detail
     * @param int $status
     * @param string $code
     *
     * @return \Generated\Shared\Transfer\RestErrorMessageTransfer
     */
    protected function createErrorMessageTransfer(
        string $detail,
        int $status,
        string $code
    ): RestErrorMessageTransfer {
        return (new RestErrorMessageTransfer())
            ->setDetail($detail)
            ->setStatus($status)
            ->setCode($code);
    }

    /**
     * @param string $authorizationToken
     *
     * @return array
     */
    protected function extractToken(string $authorizationToken): array
    {
        return preg_split('/\s+/', $authorizationToken);
    }

    /**
     * @param string $authorizationToken
     *
     * @return \Generated\Shared\Transfer\OauthAccessTokenValidationResponseTransfer
     */
    protected function validateAccessToken(string $authorizationToken): OauthAccessTokenValidationResponseTransfer
    {
        [$type, $accessToken] = $this->extractToken($authorizationToken);

        $authAccessTokenValidationRequestTransfer = new OauthAccessTokenValidationRequestTransfer();
        $authAccessTokenValidationRequestTransfer
            ->setAccessToken($accessToken)
            ->setType($type);

        $authAccessTokenValidationResponseTransfer = $this->oauthClient->validateAccessToken(
            $authAccessTokenValidationRequestTransfer
        );

        return $authAccessTokenValidationResponseTransfer;
    }
}
