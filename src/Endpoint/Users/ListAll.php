<?php

namespace MatthijsThoolen\Slacky\Endpoint\Users;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\User;
use MatthijsThoolen\Slacky\Slacky;

/**
 * Class ListAll
 * More info: https://api.slack.com/methods/users.list
 */
class ListAll extends Endpoint
{

    /** @var string */
    public $method = 'GET';

    /** @var string */
    public $uri = 'users.list';

    /**
     * @param Slacky $slacky
     * @return User[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(Slacky $slacky) : array
    {
        // Switch to cursor based pagination
        $body = parent::request($slacky);

        $users = array();

        if ($body['ok'] === true) {
            foreach ($body['members'] as $member) {
                $users[] = new User($member);
            }
        }

        return $users;
    }

}
