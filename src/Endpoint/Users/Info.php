<?php

namespace MatthijsThoolen\Slacky\Endpoint\Users;

use GuzzleHttp\Psr7\Response;
use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\User;

/**
 * Class Info
 *
 * Endpoint for the User.info slack API.
 * @documentation https://api.slack.com/methods/users.info
 */
class Info extends Endpoint
{
    /** @var string */
    protected $method = 'GET';

    /** @var string */
    protected $uri = 'users.info';

    /** @var User */
    private $user;

    /**
     * Info constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @inheritDoc
     */
    public function getParameters()
    {
        $this->parameters = array('user' => $this->user->getId());

        return parent::getParameters();
    }

    /**
     * @param Response $response
     * @return User
     */
    public function handleResponse(Response $response)
    {
        $body = parent::handleResponse($response);

        // TODO: Update the given user instead of creating a new one
        return new User($body);
    }
}
