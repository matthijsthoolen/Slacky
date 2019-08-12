<?php

namespace MatthijsThoolen\Slacky\Endpoint\Im;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Model\Im;
use MatthijsThoolen\Slacky\Model\SlackyResponse;
use MatthijsThoolen\Slacky\Model\User;
use MatthijsThoolen\Slacky\Slacky;

/**
 * Class Open
 * @documentation https://api.slack.com/methods/im.open
 */
class Open extends Endpoint
{
    /** @var string */
    protected $method = 'POST';

    /** @var string */
    protected $uri = 'im.open';

    /** @var Im */
    private $im;

    /** @var User */
    private $user;

    public function __construct(Slacky $slacky)
    {
        parent::__construct($slacky);
        $this->parameters['return_im'] = true;
    }

    /**
     * @param Im $im
     * @return $this
     * @throws SlackyException
     */
    public function setIm(Im $im)
    {
        $this->im = $im;

        if ($im->getUser() === null) {
            throw new SlackyException('Im user is not set!');
        }
        $this->parameters['user'] = $im->getUser()->getId();

        return $this;
    }

    /**
     * @param User $user
     * @return Open
     */
    public function setUser(User $user)
    {
        $this->parameters['user'] = $user->getId();
        $this->user               = $user;

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

        /** @noinspection PhpUndefinedMethodInspection */
        $body = $response->getChannel();

        if ($this->im === null) {
            $this->im = new Im();
        }

        $this->im->loadData($body);

        if ($this->user !== null) {
            $this->im->setUser($this->user);
        }

        $response->setObject($this->im);

        return $response;
    }
}
