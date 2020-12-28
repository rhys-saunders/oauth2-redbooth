<?php
namespace RhysSaunders\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;
use RhysSaunders\OAuth2\Client\Provider\Exception\RedboothProviderException;

/**
 * Class Redbooth
 *
 * @author Rhys Saunders <rhyssaunders90@gmail.com>
 *
 * @package RhysSaunders\OAuth2\Client\Provider
 */
class Redbooth extends AbstractProvider
{
    /**
     * Returns the base URL for authorizing a client.
     *
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return 'https://redbooth.com/oauth2/authorize';
    }


    /**
     * Returns the base URL for requesting an access token.
     *
     * @param array $params
     *
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return 'https://redbooth.com/oauth2/oauth.access';
    }

    /**
     * Returns the URL for requesting the resource owner's details.
     *
     * @param AccessToken $token
     *
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        $authorizedUser = $this->getAuthorizedUser($token);

        $params = [
            'token' => $token->getToken(),
            'user'  => $authorizedUser->getId()
        ];

        return 'https://redbooth.com/oauth2/users.info?' . http_build_query($params);
    }


    /**
     * @return array
     */
    protected function getDefaultScopes()
    {
        return [];
    }

    /**
     * Checks a provider response for errors.
     *
     * @param ResponseInterface $response
     * @param array|string      $data Parsed response data
     *
     * @return \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     * @throws \RhysSaunders\OAuth2\Client\Provider\Exception\RedboothProviderException
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if (isset($data['ok']) && $data['ok'] === false) {
            return RedboothProviderException::fromResponse($response, $data['error']);
        }
    }

    /**
     * Create new resources owner using the generated access token.
     *
     * @param array       $response
     * @param AccessToken $token
     *
     * @return RedboothResourceOwner
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new RedboothResourceOwner($response);
    }
}
