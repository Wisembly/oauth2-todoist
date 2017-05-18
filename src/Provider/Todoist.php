<?php
namespace Wisembly\OAuth2\Client\Provider;

use Psr\Http\Message\ResponseInterface;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;

class Todoist extends AbstractProvider
{
    public function getBaseAuthorizationUrl()
    {
        return 'https://todoist.com/oauth/authorize';
    }

    public function getBaseAccessTokenUrl(array $params)
    {
        return 'https://todoist.com/oauth/access_token';
    }

    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        $url = 'https://todoist.com/API/v7/sync';
        $query = $this->buildQueryString([
            'token' => $token->getToken(),
            'sync_token' => '*',
            'resource_types' => '["user"]'
        ]);

        return $this->appendQuery($url, $query);
    }

    protected function getDefaultScopes()
    {
        return ['data:read'];
    }

    protected function checkResponse(ResponseInterface $response, $data)
    {
        if (400 <= $response->getStatusCode()) {
            throw new IdentityProviderException(
                $data['error'],
                0,
                $response
            );
        }
    }

    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new TodoistUser($response['user']);
    }

}