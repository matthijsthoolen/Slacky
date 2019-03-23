<?php

namespace MatthijsThoolen\Slacky\Endpoint\Users;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\User;
use MatthijsThoolen\Slacky\Slacky;

/**
 * Class Info
 *
 * Endpoint for the User.info slack API. More info: https://api.slack.com/methods/users.info
 */
class Info extends Endpoint
{
    /** @var string */
    protected $method = 'GET';

    /** @var string */
    protected $uri = 'users.info';

    /** @var string */
    private $userId;

    /**
     * Info constructor.
     * @param string $userId
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @param Slacky $slacky
     * @return User
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(Slacky $slacky) : User
    {
        $this->parameters = array('user' => $this->userId);

        $body = parent::request($slacky);

        return new User($body);
    }

}
