<?php

namespace MatthijsThoolen\Slacky\Endpoint\Chat;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Model\Message\Message;
use MatthijsThoolen\Slacky\Model\SlackyResponse;

class PostEphemeral extends Endpoint
{
    /** @var string */
    protected $method = 'POST';

    /** @var string */
    protected $uri = 'chat.postEphemeral';

    /** @var Message */
    protected $message;

    /**
     * @param Message $message
     * @return $this
     */
    public function setMessage(Message $message)
    {
        $this->message = $this->parameters = $message;

        return $this;
    }

    /**
     * @param SlackyResponse $response
     * @return SlackyResponse
     * @throws SlackyException
     */
    public function handleResponse(SlackyResponse $response)
    {
        parent::handleResponse($response);

        /** @noinspection PhpUndefinedMethodInspection */
        $body = $response->getBody();

        $this->message->setTs($body['message_ts']);
        $this->message->setEphemeral(true);

        $response->setObject($this->message);

        return $response;
    }
}
