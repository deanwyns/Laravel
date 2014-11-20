<?php

namespace App\Providers;

use Exception;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Route;
use Dingo\Api\Auth\AuthorizationProvider;
use League\OAuth2\Server\Resource;
use League\OAuth2\Server\Exception\InvalidScopeException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

use LucaDegasperi\OAuth2Server\Authorizer;

class OAuth2Provider extends AuthorizationProvider
{
    /**
     * OAuth 2.0 resource server instance.
     *
     * @var \League\OAuth2\Server\Resource
     */
    protected $authorizer;

    /**
     * Indicates whether access token is limited to headers only.
     *
     * @var bool
     */
    protected $httpHeadersOnly = false;

    /**
     * User resolver.
     *
     * @var callable
     */
    protected $userResolver;

    /**
     * Client resolver.
     *
     * @var callable
     */
    protected $clientResolver;

    /**
     * Create a new OAuth 2.0 provider instance.
     *
     * @param  \LucaDegasperi\OAuth2Server\Authorizer  $authorizer
     * @param  bool  $httpHeadersOnly
     * @return void
     */
    public function __construct(Authorizer $authorizer, $httpHeadersOnly = false)
    {
        $this->authorizer = $authorizer;
        $this->httpHeadersOnly = $httpHeadersOnly;
    }

    /**
     * Authenticate request with the OAuth 2.0 resource server.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Routing\Route  $route
     * @return mixed
     * @throws \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException
     */
    public function authenticate(Request $request, Route $route)
    {
        try {
            $this->validateAuthorizationHeader($request);
        } catch (Exception $exception) {
            if (! $request->query('access_token', false)) {
                throw $exception;
            }
        }

        try {
            $this->authorizer->validateAccessToken($this->httpHeadersOnly);

            $this->validateRouteScopes($route);

            return $this->resolveResourceOwner();
        } catch (OAuthException $exception) {
            throw new UnauthorizedHttpException('Bearer', $exception->getMessage(), $exception);
        }
    }

    /**
     * Resolve the resource owner.
     *
     * @return mixed
     */
    protected function resolveResourceOwner()
    {
        if ($this->authorizer->getResourceOwnerType() == 'client') {
            return call_user_func($this->clientResolver, $this->authorizer->getResourceOwnerId());
        }

        return call_user_func($this->userResolver, $this->authorizer->getResourceOwnerId());
    }

    /**
     * Validate a routes scopes.
     *
     * @return bool
     * @throws \League\OAuth2\Server\Exception\InvalidAccessTokenException
     */
    protected function validateRouteScopes(Route $route)
    {
        $scopes = $route->scopes();

        if (empty($scopes)) {
            return true;
        }

        $u = $this->resolveResourceOwner();
        foreach ($scopes as $scope) {
            if (/*$this->authorizer->hasScope($scope) && */$scope === strtolower(get_class($u->userable))) {
                return true;
            }
        }

        throw new InvalidScopeException(implode(', ', $scopes));
    }

    /**
     * Set the resolver to fetch a user.
     *
     * @param  callable  $resolver
     * @return \Dingo\Api\Auth\LeagueOAuth2Provider
     */
    public function setUserResolver(callable $resolver)
    {
        $this->userResolver = $resolver;

        return $this;
    }

    /**
     * Set the resolver to fetch a client.
     *
     * @param  callable  $resolver
     * @return \Dingo\Api\Auth\LeagueOAuth2Provider
     */
    public function setClientResolver(callable $resolver)
    {
        $this->clientResolver = $resolver;

        return $this;
    }

    /**
     * Get the providers authorization method.
     *
     * @return string
     */
    public function getAuthorizationMethod()
    {
        return 'bearer';
    }
}
