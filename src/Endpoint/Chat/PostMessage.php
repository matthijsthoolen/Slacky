<?php

namespace MatthijsThoolen\Slacky\Endpoint\Chat;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\Message\Message;
use MatthijsThoolen\Slacky\Model\SlackyResponse;

/**
 * Class postMessage
 *
 * @documentation https://api.slack.com/methods/chat.postMessage
 */
class PostMessage extends Endpoint
{
    /** @var string */
    protected $method = 'POST';

    /** @var string */
    protected $uri = 'chat.postMessage';

    /** @var Message */
    protected $message;

    /**
     * @param Message $message
     * @return PostMessage
     */
    public function setMessage(Message $message)
    {
        $this->message = $this->parameters = $message;

        return $this;
    }

    /**
     * @param SlackyResponse $response
     * @return Message
     * @throws \Exception
     */
    public function handleResponse(SlackyResponse $response)
    {
        parent::handleResponse($response);

        /** @noinspection PhpUndefinedMethodInspection */
        $body = $response->getMessage();

        $this->message->loadData($body);

        return $this->message;
    }
}
