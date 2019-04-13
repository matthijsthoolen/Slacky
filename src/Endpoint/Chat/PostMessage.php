<?php

namespace MatthijsThoolen\Slacky\Endpoint\Chat;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\Message\Message;

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
}
