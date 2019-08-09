<?php

namespace MatthijsThoolen\Slacky\Model\Message;

use MatthijsThoolen\Slacky\Endpoint\Chat\Delete;
use MatthijsThoolen\Slacky\Endpoint\Chat\PostMessage;
use MatthijsThoolen\Slacky\Endpoint\Chat\Update;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Slacky;
use MatthijsThoolen\Slacky\SlackyFactory;

/**
 * Class Message
 */
class Message extends BaseMessage
{
    /** @var string */
    private $ts;

    /**
     * Message constructor.
     * @param Slacky|null $slacky
     */
    public function __construct(Slacky $slacky = null)
    {
        parent::__construct($slacky);

        $this->allowedProperties[] = 'ts';
    }

    /**
     * @return string
     */
    public function getTs(): string
    {
        return $this->ts;
    }

    /**
     * @param string $ts
     *
     * @return $this
     */
    public function setTs(string $ts)
    {
        $this->ts = $ts;

        return $this;
    }

    /** ACTIONS */

    /**
     * @return bool
     * @throws SlackyException
     */
    public function send()
    {
        /** @var PostMessage $postMessage */
        $postMessage = SlackyFactory::build(PostMessage::class);
        $response    = $postMessage->setMessage($this)->send();

        return $response->isOk();
    }

    /**
     * @return bool
     * @throws SlackyException
     */
    public function delete()
    {
        /** @var Delete $deleteMessage */
        $deleteMessage = SlackyFactory::build(Delete::class);
        $response      = $deleteMessage->setMessage($this)->send();

        if ($response->isOk()) {
            $this->ts = null;
        }

        return $response->isOk();
    }

    /**
     * @return bool
     * @throws SlackyException
     */
    public function update()
    {
        /** @var Update $updateMessage */
        $updateMessage = SlackyFactory::build(Update::class);
        $response      = $updateMessage->setMessage($this)->send();

        return $response->isOk();
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $data = parent::jsonSerialize();

        if ($this->ts !== null) {
            $data['ts'] = $this->ts;
        }

        return $data;
    }
}
