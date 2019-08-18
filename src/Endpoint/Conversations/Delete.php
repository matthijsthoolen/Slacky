<?php

namespace MatthijsThoolen\Slacky\Endpoint\Conversations;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\Conversation;

/**
 * Be aware that this API is not officially supported by Slack!!! It will most likely not work
 * with a normal API token.
 */
class Delete extends Endpoint
{
    /** @var string */
    protected $method = 'POST';

    /** @var string */
    protected $uri = 'conversations.delete';

    /** @var Conversation */
    protected $channel;

    /**
     * @return Conversation
     */
    public function getChannel(): Conversation
    {
        return $this->channel;
    }

    /**
     * @param Conversation $channel
     * @return Delete
     */
    public function setChannel(Conversation $channel): Delete
    {
        $this->channel               = $channel;
        $this->parameters['channel'] = $channel->getId();
        return $this;
    }
}
