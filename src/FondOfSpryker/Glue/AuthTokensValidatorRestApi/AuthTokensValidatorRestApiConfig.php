<?php

declare(strict_types=1);

namespace FondOfSpryker\Glue\AuthTokensValidatorRestApi;

use Spryker\Glue\CheckoutRestApi\CheckoutRestApiConfig as SprykerCheckoutRestApiConfig;

class AuthTokensValidatorRestApiConfig extends SprykerCheckoutRestApiConfig
{
    public const HEADER_AUTHORIZATION = 'authorization';

    public const CONTROLLER_AUTH_TOKENS_VALIDATOR = 'auth-tokens-validator-resource';
    public const RESOURCE_ACCESS_TOKENS_VERIFY = 'verify';

    public const RESPONSE_DETAIL_INVALID_ACCESS_TOKEN = 'Invalid access token.';
    public const RESPONSE_CODE_ACCESS_CODE_INVALID = '001';

    public const RESPONSE_DETAIL_MISSING_ACCESS_TOKEN = 'Missing access token.';
    public const RESPONSE_CODE_FORBIDDEN = '002';
}
