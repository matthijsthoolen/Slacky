<?php

namespace MatthijsThoolen\Slacky\Endpoint\Conversations;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Helpers\Traits\PaginationByTime;
use MatthijsThoolen\Slacky\Model\Conversation;
use MatthijsThoolen\Slacky\Model\Message\Message;
use MatthijsThoolen\Slacky\Model\SlackyResponse;

/**
 * @documentation https://api.slack.com/methods/conversations.history
 */
class History extends Endpoint
{
    use PaginationByTime;

    /** @var string */
    protected $method = 'GET';

    /** @var string */
    protected $uri = 'conversations.history';

    /** @var Conversation */
    private $channel;

    /**
     * @return Conversation
     */
    public function getChannel(): Conversation
    {
        return $this->channel;
    }

    /**
     * @param Conversation $channel
     *
     * @return $this
     */
    public function setChannel(Conversation $channel): History
    {
        $this->channel = $channel;

        $this->parameters['channel'] = $channel->getId();
        return $this;
    }

    protected function getObjectFromResponse(SlackyResponse $response)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $messagesArray = $response->getMessages();
        $messages      = [];

        foreach ($messagesArray as $message) {
            $messages[] = (new Message())->loadData($message);
        }

        $response->setObject($messages);

        return $messages;
    }
}
