<?php

namespace MatthijsThoolen\Slacky\Endpoint\Channels;

use GuzzleHttp\Psr7\Response;
use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\Channel;

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
     * @param Response $response
     * @return Channel[]
     */
    public function handleResponse(Response $response)
    {
        $body = parent::handleResponse($response);

        $channels = array();

        if ($body['ok'] === true) {
            foreach ($body['channels'] as $channel) {
                $channels[] = (new Channel())->loadData($channel);
            }
        }

        return $channels;
    }
}
