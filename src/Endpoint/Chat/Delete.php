<?php

namespace MatthijsThoolen\Slacky\Endpoint\Chat;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\Message\Message;
use MatthijsThoolen\Slacky\Model\SlackyResponse;

/**
 * Class Delete
 * Documentation: https://api.slack.com/methods/chat.delete
 */
class Delete extends Endpoint
{
    /** @var string */
    protected $method = 'POST';

    /** @var string */
    protected $uri = 'chat.delete';

    /** @var Message */
    protected $message;

    /**
     * @param Message $message
     * @return Delete
     */
    public function setMessage(Message $message)
    {
        $this->message = $this->parameters = $message;

        return $this;
    }

    /**
     * @param SlackyResponse $response
     * @return SlackyResponse
     * @throws \Exception
     */
    public function handleResponse(SlackyResponse $response)
    {
        parent::handleResponse($response);

        return $response;
    }
}
