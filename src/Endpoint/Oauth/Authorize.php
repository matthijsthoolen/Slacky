<?php

namespace MatthijsThoolen\Slacky\Endpoint\Oauth;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;

class Authorize extends Endpoint
{
    /** @var string */
    protected $method = 'GET';

    /** @var string */
    protected $uri = 'oauth.authorize';

    /** @var Authorize */
    protected $authorize;

    /**
     * @return Authorize
     */
    public function getAuthorize(): Authorize
    {
        return $this->authorize;
    }

    /**
     * @param Authorize $authorize
     * @return Authorize
     */
    public function setAuthorize(Authorize $authorize): Authorize
    {
        $this->authorize = $authorize;
        return $this;
    }
}
