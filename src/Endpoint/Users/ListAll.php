<?php

namespace MatthijsThoolen\Slacky\Endpoint\Users;

use GuzzleHttp\Psr7\Response;
use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\User;

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
     * @param Response $response
     * @return User[]
     */
    public function request(Response $response)
    {
        //TODO: Switch to cursor based pagination
        $body = parent::handleResponse($response);

        $users = array();

        if ($body['ok'] === true) {
            foreach ($body['members'] as $member) {
                $users[] = new User($member);
            }
        }

        return $users;
    }

}
