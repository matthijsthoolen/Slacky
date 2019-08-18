<?php

namespace MatthijsThoolen\Slacky\Endpoint\Conversations;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\Conversation;

/**
 * @documentation https://api.slack.com/methods/conversations.setTopic
 */
class SetTopic extends Endpoint
{
    /** @var string */
    protected $method = 'POST';

    /** @var string */
    protected $uri = 'conversations.setTopic';

    /** @var Conversation */
    private $channel;

    /** @var string */
    private $topic;

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
    public function setChannel(Conversation $channel): SetTopic
    {
        $this->channel = $channel;

        $this->parameters['channel'] = $channel->getId();
        return $this;
    }

    /**
     * @return string
     */
    public function getTopic(): string
    {
        return $this->topic;
    }/**

    /**
     * @param string $topic
     * @return SetTopic
     */
    public function setTopic(string $topic): SetTopic
    {
        $this->topic = $this->parameters['topic'] = $topic;
        return $this;
    }
}
