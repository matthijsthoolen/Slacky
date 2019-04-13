<?php

namespace MatthijsThoolen\Slacky\Endpoint;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use MatthijsThoolen\Slacky\Slacky;
use Psr\Http\Message\ResponseInterface;

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

    /** @var Slacky */
    private $slacky;

    public function __construct(Slacky $slacky)
    {
        $this->slacky = $slacky;
    }

    /**
     * Send the request
     *
     * @return mixed
     * @throws GuzzleException
     */
    public function send()
    {
        return $this->slacky->sendRequest($this);
    }

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
    public function getParameters()
    {
        if ($this->method === 'GET') {
            return array(
                'query' => $this->parameters
            );
        } else if ($this->method === 'POST') {
            return [
                'headers' => [
                    'content-type' => 'application/json; charset=utf-8',
                ],
                'body' => json_encode($this->parameters)
            ];
        }
    }

    /**
     * @param Response $response
     * @return mixed|ResponseInterface
     */
    public function handleResponse(Response $response)
    {
        return json_decode($response->getBody()->getContents(), true);
    }

}
