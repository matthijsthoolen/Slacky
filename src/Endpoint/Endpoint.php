<?php

namespace MatthijsThoolen\Slacky\Endpoint;

use \Exception;
use GuzzleHttp\Exception\GuzzleException;
use function json_encode;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Model\Model;
use MatthijsThoolen\Slacky\Model\SlackyResponse;
use MatthijsThoolen\Slacky\Slacky;

/**
 * Endpoints are splitted and structured into separate folders based on this list
 * @documentation: https://api.slack.com/methods
 */
abstract class Endpoint
{
    /** @var string */
    protected $method = 'POST';

    /** @var string */
    protected $contentType = 'json';

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
     * @return SlackyResponse
     * @throws SlackyException
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
     * @return SlackyResponse
     * @throws SlackyException
     */
    public function sendExpectArray()
    {
        return $this->send('array');
    }

    /**
     * @return Model
     * @throws SlackyException
     */
    public function sendExpectModel()
    {
        $response = $this->send('model');

        /** @var Model $object */
        $object = $response->getObject();
        return $object;
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
            if ($this->contentType === 'urlencoded') {
                return [];
            }
            return array(
                'query' => $this->parameters
            );
        } else {
            if ($this->method === 'POST' && $this->contentType === 'json') {
                return [
                    'headers' => [
                        'content-type' => 'application/json; charset=utf-8',
                    ],
                    'body'    => json_encode($this->parameters)
                ];
            } else {
                if ($this->method === 'POST' && $this->contentType === 'urlencoded') {
                    return [
                        'headers'     => [
                            'content-type' => 'application/x-www-form-urlencoded; charset=utf-8',
                        ],
                        'form_params' => $this->parameters
                    ];
                } else {
                    if ($this->method === 'POST' && $this->contentType === 'form-data') {
                        return [
                            'headers'   => [
                                'content-type' => 'multipart/form-data; charset=utf-8',
                            ],
                            'multipart' => $this->parameters
                        ];
                    }
                }
            }
        }

        return [];
    }

    /**
     * @param SlackyResponse $response
     * @return SlackyResponse
     * @throws SlackyException
     */
    public function handleResponse(SlackyResponse $response)
    {
        if ($response->isOk() === true) {
            return $response;
        }

        throw new SlackyException(
            'A slack response failed to execute. Reason: ' . $response->getError(), 0, $response
        );
    }
}
