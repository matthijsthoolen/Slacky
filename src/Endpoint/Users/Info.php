<?php

namespace MatthijsThoolen\Slacky\Endpoint\Users;

use Exception;
use GuzzleHttp\Psr7\Response;
use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\SlackyResponse;
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
     * @param User $user
     */
    public function setModel($user = null)
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
     * @param SlackyResponse $response
     * @return User|array
     * @throws Exception
     */
    public function handleResponse(SlackyResponse $response)
    {
        parent::handleResponse($response);

        // TODO: Update the given user instead of creating a new one
        return $this->expectedResponse === 'user' ? (new User())->loadData($response->getBody()) : $response->getBody();
    }
}
