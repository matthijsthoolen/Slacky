<?php

namespace MatthijsThoolen\Slacky\Endpoint;

use MatthijsThoolen\Slacky\Slacky;

/**
 * Endpoints are splitted and structured into seperate folders based on this list: https://api.slack.com/methods
 */
abstract class Endpoint
{

    /** @var string */
    protected $method = 'POST';

    /** @var string */
    protected $uri;

    /** @var array */
    protected $parameters = array();

    /**
     * Return the http method
     *
     * @returns string
     */
    public function getMethod() : string
    {
        return $this->method;
    }

    /**
     * Return the path after the base-uri
     *
     * @returns string
     */
    public function getUri() : string
    {
        return $this->uri;
    }

    /**
     * @returns array
     */
    public function getParameters() : array
    {
        if ($this->method === 'GET') {
            return array(
                'query' => $this->parameters
            );
        }
    }

    /**
     * @return array
     */
    public function getHeaders() : array
    {
        return $this->headers;
    }

    /**
     * @param Slacky $slacky
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(Slacky $slacky)
    {
        $response = $slacky->sendRequest($this);
        return json_decode($response->getBody()->getContents(), true);
    }

}
