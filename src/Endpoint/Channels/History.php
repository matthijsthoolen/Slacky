<?php

namespace MatthijsThoolen\Slacky\Endpoint\Channels;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Model\SlackyResponse;

/**
 * Class History
 * More info: https://api.slack.com/methods/channels.history
 */
class History extends Endpoint
{
    /** @var string */
    public $method = 'POST';

    /** @var string */
    public $uri = 'channels.history';

    /** @var string */
    protected $channel;

    /** @var int */
    protected $count;

    /** @var bool */
    protected $inclusive;

    /** @var string */
    protected $latest;

    /** @var string */
    protected $oldest;

    /** @var int */
    protected $unreads;

    /**
     * @param SlackyResponse $response
     * @return SlackyResponse
     * @throws SlackyException
     */
    public function request(SlackyResponse $response)
    {
        $body = parent::handleResponse($response);

        return $body;
    }
}
