<?php

namespace MatthijsThoolen\Slacky\Endpoint\Conversations;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\Channel;
use MatthijsThoolen\Slacky\Model\Im;
use MatthijsThoolen\Slacky\Model\Message\Message;
use MatthijsThoolen\Slacky\Model\SlackyResponse;

class Info extends Endpoint
{
    /** @var string */
    protected $method = 'GET';

    /** @var string */
    protected $uri = 'conversations.info';

    /** @var Im|Channel */
    protected $conversation;

    /**
     * @param boolean $include
     * @return $this
     */
    public function setIncludeLocale(bool $include): Info
    {
        $this->parameters['include_locale'] = $include;

        return $this;
    }

    /**
     * @param boolean $numMembers
     * @return $this
     */
    public function setIncludeNumMembers(bool $numMembers): Info
    {
        $this->parameters['include_num_members'] = $numMembers;

        return $this;
    }

    /**
     * @param Im|Channel $conversation
     * @return $this
     */
    public function setConversation($conversation): Info
    {
        $this->conversation          = $conversation;
        $this->parameters['channel'] = $conversation->getId();

        return $this;
    }

    public function handleResponse(SlackyResponse $response)
    {
        parent::handleResponse($response);
        /** @noinspection PhpUndefinedMethodInspection */
        $response->setObject($this->conversation->loadData($response->getChannel()));

        return $response;
    }
}
