<?php

namespace MatthijsThoolen\Slacky\Endpoint\Conversations;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\Conversation;
use MatthijsThoolen\Slacky\Model\Channel;

/**
 * @documentation https://api.slack.com/methods/conversations.archive
 */
class Archive extends Endpoint
{
    /** @var string */
    protected $method = 'POST';

    /** @var string */
    protected $uri = 'conversations.archive';

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
     * @return $this
     */
    public function setChannel(Conversation $channel): Archive
    {
        $this->channel = $channel;

        $this->parameters['channel'] = $channel->getId();
        return $this;
    }
}
