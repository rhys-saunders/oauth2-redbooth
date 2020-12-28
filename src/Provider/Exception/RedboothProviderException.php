<?php

namespace RhysSaunders\OAuth2\Client\Provider\Exception;

use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Psr\Http\Message\ResponseInterface;

class RedboothProviderException extends IdentityProviderException
{
    /**
     * @param  ResponseInterface $response
     * @param  string|null       $message
     *
     * @return IdentityProviderException
     * @throws \RhysSaunders\OAuth2\Client\Provider\Exception\RedboothProviderException
     */
    public static function fromResponse(ResponseInterface $response, $message = null)
    {
        throw new static($message, $response->getStatusCode(), (string) $response->getBody());
    }
}