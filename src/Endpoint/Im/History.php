<?php

namespace MatthijsThoolen\Slacky\Endpoint\Im;

use Iterator;
use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Model\Im;
use MatthijsThoolen\Slacky\Model\Message\MessageIterable;
use MatthijsThoolen\Slacky\Model\SlackyResponse;

/**
 * Class Open
 * @documentation https://api.slack.com/methods/im.history
 */
class History extends Endpoint
{
    /** @var string */
    protected $method = 'GET';

    /** @var string */
    protected $uri = 'im.history';

    /** @var Im */
    private $im;

    /** @var int */
    private $count;

    /** @var bool */
    private $inclusive;

    /** @var float */
    private $latest;

    /** @var float */
    private $oldest;

    /** @var int */
    private $unreads;

    /** @var bool */
    private $next = false;

    /**
     * @return Im
     */
    public function getIm(): Im
    {
        return $this->im;
    }

    /**
     * Direct message channel to fetch history for.
     *
     * @param Im $im
     * @return History
     */
    public function setIm(Im $im): History
    {
        $this->im                    = $im;
        $this->parameters['channel'] = $im->getId();
        return $this;
    }

    /**
     * Number of messages to return, between 1 and 1000.
     *
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     * @return History
     */
    public function setCount(int $count): History
    {
        $this->count = $this->parameters['count'] = $count;
        return $this;
    }

    /**
     * Include messages with latest or oldest timestamp in results.
     *
     * @return bool
     */
    public function isInclusive(): bool
    {
        return $this->inclusive;
    }

    /**
     * @param bool $inclusive
     * @return History
     */
    public function setInclusive(bool $inclusive): History
    {
        $this->inclusive = $this->parameters['inclusive'] = $inclusive;
        return $this;
    }

    /**
     * End of time range of messages to include in results.
     *
     * @return float
     */
    public function getLatest(): float
    {
        return $this->latest;
    }

    /**
     * @param float $latest
     * @return History
     */
    public function setLatest(float $latest): History
    {
        $this->latest = $this->parameters['latest'] = $latest;
        return $this;
    }

    /**
     * @return float
     */
    public function getOldest(): float
    {
        return $this->oldest;
    }

    /**
     * Start of time range of messages to include in results.
     *
     * @param float $oldest
     * @return History
     */
    public function setOldest(float $oldest): History
    {
        $this->oldest = $this->parameters['oldest'] = $oldest;
        return $this;
    }

    /**
     * Include unread_count_display in the output?
     *
     * @return int
     */
    public function getUnreads(): int
    {
        return $this->unreads;
    }

    /**
     * @param int $unreads
     * @return History
     */
    public function setUnreads(int $unreads): History
    {
        $this->unreads = $this->parameters['unreads'] = $unreads;
        return $this;
    }

    public function next()
    {
        $this->next = true;

        try {
            $data = $this->send();
        } catch (SlackyException $e) {
            $data = [];
        }

        $this->next = false;

        return $data;
    }

    /**
     * @param SlackyResponse $response
     * @return Iterator|array
     * @throws SlackyException
     */
    public function handleResponse(SlackyResponse $response)
    {
        parent::handleResponse($response);

        $body = $response->getBody();
        /** @noinspection PhpUndefinedMethodInspection */
        $messages = $response->getMessages();
        reset($messages);

        $lastMessage = end($messages);
        $this->setLatest($lastMessage['ts']);

        // If in next loop, we dont need to return the entire iterable (might be fixed better...)
        if ($this->next) {
            return [
                'data'    => $messages,
                'hasMore' => $body['has_more']
            ];
        }

        $iterable = new MessageIterable(
            $messages,
            $body['has_more'],
            function () {
                return $this->next();
            }
        );

        return $iterable;
    }
}
