<?php

namespace MatthijsThoolen\Slacky\Endpoint\Chat;

use Exception;
use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\Message\Message;
use MatthijsThoolen\Slacky\Model\Message\ScheduledMessage;
use MatthijsThoolen\Slacky\Model\SlackyResponse;

/**
 * @documentation https://api.slack.com/methods/chat.scheduleMessage
 */
class ScheduleMessage extends Endpoint
{
    /** @var string */
    protected $method = 'POST';

    /** @var string */
    protected $uri = 'chat.scheduleMessage';

    /** @var ScheduledMessage */
    protected $message;

    /**
     * @param ScheduledMessage $message
     * @return $this
     */
    public function setMessage(ScheduledMessage $message)
    {
        $this->message = $this->parameters = $message;

        return $this;
    }

    /**
     * @param SlackyResponse $response
     * @return SlackyResponse
     * @throws Exception
     */
    public function handleResponse(SlackyResponse $response)
    {
        parent::handleResponse($response);

        $body = $response->getBody();
        $this->message->loadData($body);

        $response->setObject($this->message);

        return $response;
    }
}
