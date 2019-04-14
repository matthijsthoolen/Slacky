<?php

namespace MatthijsThoolen\Slacky;

use Exception;
use GuzzleHttp\Client;
use MatthijsThoolen\Slacky\Endpoint\Endpoint;
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
     * @throws Exception
     */
    public function sendRequest($object)
    {
        return new SlackyResponse($this->client->request($object->getMethod(), $object->getUri(), $object->getParameters()));
    }
}
