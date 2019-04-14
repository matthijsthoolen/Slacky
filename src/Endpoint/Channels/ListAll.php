<?php

namespace MatthijsThoolen\Slacky\Endpoint\Channels;

use Exception;
use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\Channel;
use MatthijsThoolen\Slacky\Model\SlackyResponse;

/**
 * Class ListAll
 * @package MatthijsThoolen\Slacky\Endpoint\Channels
 */
class ListAll extends Endpoint
{
    /** @var string */
    protected $method = 'GET';

    /** @var string */
    protected $uri = 'channels.list';

    /**
     * @param SlackyResponse $response
     * @return Channel[]
     * @throws Exception
     */
    public function handleResponse(SlackyResponse $response)
    {
        $body = parent::handleResponse($response);

        $channels = array();

        /** @noinspection PhpUndefinedMethodInspection */
        $bodyChannels = $body->getChannels();

        foreach ($bodyChannels as $channel) {
            $channels[] = (new Channel())->loadData($channel);
        }

        return $channels;
    }
}
