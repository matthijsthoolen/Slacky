<?php

namespace MatthijsThoolen\Slacky\Endpoint\Chat;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\Message\Message;
use MatthijsThoolen\Slacky\Model\SlackyResponse;

class DeleteScheduledMessage extends Endpoint
{
    /** @var string */
    protected $method = 'POST';

    /** @var string */
    protected $uri = 'chat.deleteScheduledMessage';

    /** @var Message */
    protected $message;

    public function setMessage(Message $message)
    {
        $this->message = $message;
    }

    public function handleResponse(SlackyResponse $response)
    {
        parent::handleResponse($response);

        /** @noinspection PhpUndefinedMethodInspection */
        $body = $response->getMessage();
        $this->message->loadData($body);

        $response->setObject($this->message);

        return $response;
    }
}
