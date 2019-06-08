<?php

namespace MatthijsThoolen\Slacky\Endpoint\Oauth;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;

/**
 * Class Access
 *
 * @documentation https://api.slack.com/methods/oauth.access
 */
class Access extends Endpoint
{
    /** @var string */
    protected $method = 'POST';

    /** @var string */
    protected $uri ='oauth.access';

    /** @var string */
    protected $clientId;

    /** @var string */
    protected $clientSecret;

    /** @var string */
    protected $code;

    /** @var string */
    protected $redirectUri;

    /** @var bool */
    protected $singleChannel = false;

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @param string $clientId
     * @return Access
     */
    public function setClientId(string $clientId): Access
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * @param string $clientSecret
     * @return Access
     */
    public function setClientSecret(string $clientSecret): Access
    {
        $this->clientSecret = $clientSecret;
        return $this;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return Access
     */
    public function setCode(string $code): Access
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getRedirectUri(): string
    {
        return $this->redirectUri;
    }

    /**
     * @param string $redirectUri
     * @return Access
     */
    public function setRedirectUri(string $redirectUri): Access
    {
        $this->redirectUri = $redirectUri;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSingleChannel(): bool
    {
        return $this->singleChannel;
    }

    /**
     * @param bool $singleChannel
     * @return Access
     */
    public function setSingleChannel(bool $singleChannel): Access
    {
        $this->singleChannel = $singleChannel;
        return $this;
    }


}
