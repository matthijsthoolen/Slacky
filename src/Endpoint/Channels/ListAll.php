<?php

namespace MatthijsThoolen\Slacky\Endpoint\Channels;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\Channel;
use MatthijsThoolen\Slacky\Slacky;

class ListAll extends Endpoint
{
    /** @var string */
    protected $method = 'GET';

    /** @var string */
    protected $uri = 'channels.list';

    public function request(Slacky $slacky) : array
    {
        $body = parent::request($slacky);

        $channels = array();

        if ($body['ok'] === true) {
            foreach ($body['channels'] as $channel) {
                $channels[] = new Channel($channel);
            }
        }

        return $channels;
    }
}
