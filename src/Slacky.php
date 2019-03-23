<?php

namespace MatthijsThoolen\Slacky;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;

class Slacky
{

    /** @var \GuzzleHttp\Client */
    private $client;

    public function __construct()
    {
        $token = getenv('SLACK_BOT_TOKEN');

        $this->client = ClientFactory::create($token);
    }

    /**
     * @param Endpoint $object
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendRequest($object)
    {
        return $this->client->request($object->getMethod(), $object->getUri(), $object->getParameters());
    }

}
