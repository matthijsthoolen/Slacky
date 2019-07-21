<?php

namespace MatthijsThoolen\Slacky\Endpoint\Chat;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\Message\ScheduledMessage;
use MatthijsThoolen\Slacky\Model\SlackyResponse;

class DeleteScheduledMessage extends Endpoint
{
    /** @var string */
    protected $method = 'POST';

    /** @var string */
    protected $uri = 'chat.deleteScheduledMessage';

    /** @var ScheduledMessage */
    protected $message;

    /**
     * @param ScheduledMessage $message
     * @return DeleteScheduledMessage
     */
    public function setMessage(ScheduledMessage $message)
    {
        $this->message = $this->parameters = $message;

        return $this;
    }

    public function handleResponse(SlackyResponse $response)
    {
        parent::handleResponse($response);

        return $response;
    }
}
