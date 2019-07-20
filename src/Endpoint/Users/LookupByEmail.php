<?php

namespace MatthijsThoolen\Slacky\Endpoint\Users;

use GuzzleHttp\Psr7\Response;
use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\User;

class LookupByEmail extends Endpoint
{
    /** @var string */
    protected $method = 'GET';

    /** @var string */
    protected $uri = 'users.lookupByEmail';

    /** @var string */
    private $email;

    /**
     * LookupByEmail constructor.
     * @param string $email
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * @inheritDoc
     */
    public function getParameters()
    {
        $this->parameters = array('email' => $this->email);

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
        return (new User())->loadData($body);
    }
}
