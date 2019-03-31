<?php

namespace MatthijsThoolen\Slacky;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use Psr\Http\Message\ResponseInterface;

class Slacky
{

    /** @var Client */
    private $client;

    public function __construct()
    {
        $token = getenv('SLACK_BOT_TOKEN');

        $this->client = ClientFactory::create($token);
    }

    /**
     * @param Endpoint $object
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function sendRequest($object)
    {
        return $object->handleResponse(
            $this->client->request($object->getMethod(), $object->getUri(), $object->getParameters())
        );
    }
}
