<?php

namespace MatthijsThoolen\Slacky\Endpoint\Chat;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Model\SlackyResponse;

class GetPermalink extends Endpoint
{
    /** @var string */
    protected $method = 'GET';

    /** @var string */
    protected $uri = 'chat.getPermalink';

    /** @var string */
    private $channel;

    /** @var string */
    private $messageTs;

    /**
     * @param string $channel
     * @return $this
     */
    public function setChannel(string $channel)
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * @param string $ts
     * @return $this
     */
    public function setMessageTs(string $ts)
    {
        $this->messageTs = $ts;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getParameters()
    {
        $this->parameters = [
            'channel'    => $this->channel,
            'message_ts' => $this->messageTs
        ];

        return parent::getParameters();
    }

    /**
     * @param SlackyResponse $response
     * @return SlackyResponse
     * @throws SlackyException
     */
    public function handleResponse(SlackyResponse $response)
    {
        parent::handleResponse($response);

        return $response;
    }
}
