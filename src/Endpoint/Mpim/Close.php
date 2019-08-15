<?php

namespace MatthijsThoolen\Slacky\Endpoint\Mpim;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Model\Im;
use MatthijsThoolen\Slacky\Model\SlackyResponse;

/**
 * @documentation https://api.slack.com/methods/mpim.close
 */
class Close extends Endpoint
{
    /** @var string */
    protected $method = 'POST';

    /** @var string */
    protected $uri = 'mpim.close';

    /** @var Im */
    private $im;

    /**
     * @param Im $im
     * @return $this
     */
    public function setIm(Im $im)
    {
        $this->im                    = $im;
        $this->parameters['channel'] = $im->getId();

        return $this;
    }

    /**
     * @param SlackyResponse $response
     * @return SlackyResponse
     * @throws SlackyException
     */
    public function handleResponse(SlackyResponse $response)
    {
        parent::handleResponse($response);

        if ($response->isOk()) {
            $this->im->setIsOpen(false);
        }

        return $response;
    }
}
