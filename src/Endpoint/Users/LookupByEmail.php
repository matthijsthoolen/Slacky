<?php

namespace MatthijsThoolen\Slacky\Endpoint\Users;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\User;
use MatthijsThoolen\Slacky\Slacky;

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

    public function request (Slacky $slacky) : User
    {
        $this->parameters = array('email' => $this->email);

        $body = parent::request($slacky);

        return new User($body);
    }


}