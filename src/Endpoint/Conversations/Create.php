<?php

namespace MatthijsThoolen\Slacky\Endpoint\Conversations;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;

/**
 * @documentation https://api.slack.com/methods/conversations.create
 */
class Create extends Endpoint
{
    /** @var string */
    protected $method = 'POST';

    /** @var string */
    protected $uri = 'conversations.create';
}
