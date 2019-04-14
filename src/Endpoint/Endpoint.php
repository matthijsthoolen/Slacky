<?php

namespace MatthijsThoolen\Slacky\Endpoint;

use \Exception;
use MatthijsThoolen\Slacky\Model\Model;
use MatthijsThoolen\Slacky\Model\SlackyResponse;
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

    /** @var Slacky */
    private $slacky;

    /** @var string */
    protected $expectedResponse;

    public function __construct(Slacky $slacky)
    {
        $this->slacky = $slacky;
    }

    /**
     * @param Model $model
     * @return self
     */
    public function setModel($model = null)
    {
        return $this;
    }

    /**
     * Send the request
     *
     * @param string $expect model or array (default)
     * @return Mixed
     * @throws Exception
     */
    public function send($expect = 'array')
    {
        if (in_array($expect, ['array', 'model'], true)) {
            $this->expectedResponse = $expect;
        }
        $response = $this->slacky->sendRequest($this);

        return $this->handleResponse($response);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function sendExpectArray()
    {
        return $this->send('array');
    }

    /**
     * @return Model
     * @throws Exception
     */
    public function sendExpectModel()
    {
        return $this->send('model');
    }

    /**
     * Return the http method
     *
     * @returns string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Return the path after the base-uri
     *
     * @returns string
     */
    public function getUri(): string
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
        } else {
            if ($this->method === 'POST') {
                return [
                    'headers' => [
                        'content-type' => 'application/json; charset=utf-8',
                    ],
                    'body'    => json_encode($this->parameters)
                ];
            }
        }
    }

    /**
     * @param SlackyResponse $response
     * @return SlackyResponse
     * @throws Exception
     */
    public function handleResponse(SlackyResponse $response)
    {
        if ($response->isOk() === true) {
            return $response;
        }

        throw new Exception('A slack response failed to execute successfully. Reason: ' . $response->getError(), 0);
    }

}
