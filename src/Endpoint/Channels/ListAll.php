<?php

namespace MatthijsThoolen\Slacky\Endpoint\Channels;

use Exception;
use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\PublicChannel;
use MatthijsThoolen\Slacky\Model\SlackyResponse;

/**
 * Class ListAll
 */
class ListAll extends Endpoint
{
    /** @var string */
    protected $method = 'GET';

    /** @var string */
    protected $uri = 'channels.list';

    /**
     * @param SlackyResponse $response
     * @return SlackyResponse
     * @throws Exception
     */
    public function handleResponse(SlackyResponse $response)
    {
        $body = parent::handleResponse($response);

        $channels = array();

        /** @noinspection PhpUndefinedMethodInspection */
        $bodyChannels = $body->getChannels();

        foreach ($bodyChannels as $channel) {
            $channels[] = (new PublicChannel())->loadData($channel);
        }

        $response->setObject($channels);

        return $response;
    }
}
