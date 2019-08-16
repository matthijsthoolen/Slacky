<?php

namespace MatthijsThoolen\Slacky\Endpoint\Chat\ScheduledMessages;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Model\PublicChannel;
use MatthijsThoolen\Slacky\Model\Message\ScheduledMessage;
use MatthijsThoolen\Slacky\Model\SlackyResponse;

class ListAll extends Endpoint
{
    /** @var string */
    protected $method = 'POST';

    /** @var string */
    protected $uri = 'chat.scheduledMessages.list';

    /** @var PublicChannel */
    private $channel;

    /** @var int */
    private $limit;

    /** @var int */
    private $latest;

    /** @var int */
    private $oldest;

    /**
     * @return PublicChannel
     */
    public function getChannel(): PublicChannel
    {
        return $this->channel;
    }

    /**
     * @param PublicChannel $channel
     * @return ListAll
     */
    public function setChannel(PublicChannel $channel): ListAll
    {
        $this->channel = $this->parameters['channel'] = $channel;
        return $this;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     * @return ListAll
     */
    public function setLimit(int $limit): ListAll
    {
        $this->limit = $this->parameters['limit'] = $limit;
        return $this;
    }

    /**
     * @return int
     */
    public function getLatest(): int
    {
        return $this->latest;
    }

    /**
     * @param int $latest
     * @return ListAll
     */
    public function setLatest(int $latest): ListAll
    {
        $this->latest = $this->parameters['latest'] = $latest;
        return $this;
    }

    /**
     * @return int
     */
    public function getOldest(): int
    {
        return $this->oldest;
    }

    /**
     * @param int $oldest
     * @return ListAll
     */
    public function setOldest(int $oldest): ListAll
    {
        $this->oldest = $this->parameters['oldest'] = $oldest;
        return $this;
    }

    /**
     * @param SlackyResponse $response
     * @return array
     * @throws SlackyException
     */
    public function handleResponse(SlackyResponse $response)
    {
        $response = parent::handleResponse($response);

        $scheduledMessages = array();

        /** @noinspection PhpUndefinedMethodInspection */
        $bodyScheduledMessages = $response->getScheduledMessages();

        if ($bodyScheduledMessages === null) {
            return $scheduledMessages;
        }

        foreach ($bodyScheduledMessages as $scheduledMessage) {
            $scheduledMessages[] = (new ScheduledMessage())->loadData($scheduledMessage);
        }

        return $scheduledMessages;
    }
}
