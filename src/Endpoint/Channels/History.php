<?php

namespace MatthijsThoolen\Slacky\Endpoint\Channels;

use GuzzleHttp\Psr7\Response;
use MatthijsThoolen\Slacky\Endpoint\Endpoint;

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

    protected $channel;

    protected $count;

    protected $inclusive;

    protected $latest;

    protected $oldest;

    protected $unreads;

    public function getParameters()
    {
        return parent::getParameters();
    }

    public function request(Response $response)
    {
        $body = parent::handleResponse($response);
    }
}
