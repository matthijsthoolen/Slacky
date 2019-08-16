<?php

namespace MatthijsThoolen\Slacky\Endpoint\Chat;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;

/**
 * @documentation https://api.slack.com/methods/chat.unfurl
 */
class Unfurl extends Endpoint
{
    /** @var string */
    protected $method = 'POST';

    /** @var string */
    protected $uri = 'chat.unfurl';

    /** @var string */
    private $channel;

    /** @var string */
    private $ts;

    /** @var string */
    private $unfurls;

    /** @var string */
    private $user_auth_message;

    /** @var bool */
    private $user_auth_required = false;

    /** @var string */
    private $user_auth_url;

    /**
     * @return string
     */
    public function getChannel(): string
    {
        return $this->channel;
    }

    /**
     * @param string $channel
     * @return Unfurl
     */
    public function setChannel(string $channel): Unfurl
    {
        $this->channel = $this->parameters['channel'] = $channel;
        return $this;
    }

    /**
     * @return string
     */
    public function getTs(): string
    {
        return $this->ts;
    }

    /**
     * @param string $ts
     * @return Unfurl
     */
    public function setTs(string $ts): Unfurl
    {
        $this->ts = $this->parameters['ts'] = $ts;
        return $this;
    }

    /**
     * @return string
     */
    public function getUnfurls(): string
    {
        return $this->unfurls;
    }

    /**
     * @param string $unfurls
     * @return Unfurl
     */
    public function setUnfurls(string $unfurls): Unfurl
    {
        $this->unfurls = $this->parameters['unfurls'] = $unfurls;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserAuthMessage(): string
    {
        return $this->user_auth_message;
    }

    /**
     * @param string $user_auth_message
     * @return Unfurl
     */
    public function setUserAuthMessage(string $user_auth_message): Unfurl
    {
        $this->user_auth_message = $this->parameters['user_auth_message'] = $user_auth_message;
        return $this;
    }

    /**
     * @return bool
     */
    public function isUserAuthRequired(): bool
    {
        return $this->user_auth_required;
    }

    /**
     * @param bool $user_auth_required
     * @return Unfurl
     */
    public function setUserAuthRequired(bool $user_auth_required): Unfurl
    {
        $this->user_auth_required = $this->parameters['user_auth_required'] = $user_auth_required;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserAuthUrl(): string
    {
        return $this->user_auth_url;
    }

    /**
     * @param string $user_auth_url
     * @return Unfurl
     */
    public function setUserAuthUrl(string $user_auth_url): Unfurl
    {
        $this->user_auth_url = $this->parameters['user_auth_url'] = $user_auth_url;
        return $this;
    }
}
