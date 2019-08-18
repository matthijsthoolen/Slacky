<?php

namespace MatthijsThoolen\Slacky\Endpoint\Conversations;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\Conversation;

/**
 * @documentation https://api.slack.com/methods/conversations.setPurpose
 */
class SetPurpose extends Endpoint
{
    /** @var string */
    protected $method = 'POST';

    /** @var string */
    protected $uri = 'conversations.setPurpose';

    /** @var Conversation */
    protected $channel;

    /** @var string */
    private $purpose;

    /**
     * @return Conversation
     */
    public function getChannel(): Conversation
    {
        return $this->channel;
    }

    /**
     * @param Conversation $channel
     * @return $this
     */
    public function setChannel(Conversation $channel): SetPurpose
    {
        $this->channel = $channel;

        $this->parameters['channel'] = $channel->getId();
        return $this;
    }

    /**
     * @return string
     */
    public function getPurpose(): string
    {
        return $this->purpose;
    }

    /**
     * @param string $purpose
     * @return SetPurpose
     */
    public function setPurpose(string $purpose): SetPurpose
    {
        $this->purpose = $this->parameters['purpose'] = $purpose;
        return $this;
    }
}
