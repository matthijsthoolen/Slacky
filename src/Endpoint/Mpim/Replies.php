<?php

namespace MatthijsThoolen\Slacky\Endpoint\Mpim;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;

/**
 * @documentation https://api.slack.com/methods/mpim.replies
 */
class Replies extends Endpoint
{
    /** @var string */
    protected $method = 'GET';

    /** @var string */
    protected $uri = 'mpim.replies';
}
