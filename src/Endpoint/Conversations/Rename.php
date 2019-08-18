<?php

namespace MatthijsThoolen\Slacky\Endpoint\Conversations;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\Conversation;

/**
 * @documentation https://api.slack.com/methods/conversations.rename
 */
class Rename extends Endpoint
{
    /** @var string */
    protected $method = 'POST';

    /** @var string */
    protected $uri = 'conversations.rename';

    /** @var Conversation */
    private $channel;

    /** @var string */
    private $name;

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
    public function setChannel(Conversation $channel): Rename
    {
        $this->channel = $channel;

        $this->parameters['channel'] = $channel->getId();
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Rename
     */
    public function setName(string $name): Rename
    {
        $this->name = $this->parameters['name'] = $name;
        return $this;
    }
}
