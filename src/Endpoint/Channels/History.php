<?php

namespace MatthijsThoolen\Slacky\Endpoint\Channels;

use GuzzleHttp\Psr7\Response;
use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Exception\SlackyException;

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
     * @param Response $response
     * @throws SlackyException
     */
    public function request(Response $response)
    {
        $body = parent::handleResponse($response);
    }
}
