<?php

namespace MatthijsThoolen\Slacky;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Model\SlackyResponse;

class Slacky
{
    /** @var Client */
    private $client;

    public function __construct($token)
    {
        $this->client = ClientFactory::create($token);
    }

    /**
     * @param Endpoint $object
     * @return SlackyResponse
     * @throws SlackyException
     */
    public function sendRequest($object)
    {
        try {
            return new SlackyResponse(
                $this->client->request(
                    $object->getMethod(),
                    $object->getUri(),
                    $object->getParameters()
                )
            );
        } catch (GuzzleException $e) {
            throw new SlackyException($e->getMessage(), null, null, $e);
        }
    }
}
