<?php

namespace MatthijsThoolen\Slacky\Endpoint\Users;

use Exception;
use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\SlackyResponse;
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
     * @param SlackyResponse $response
     * @return User[]
     * @throws Exception
     */
    public function request(SlackyResponse $response)
    {
        //TODO: Switch to cursor based pagination
        $body = parent::handleResponse($response);

        /** @noinspection PhpUndefinedMethodInspection */
        $bodyMembers = $body->getMembers();

        if ($bodyMembers === null) {
            return [];
        }

        if ($this->expectedResponse === 'array') {
            return $bodyMembers;
        }

        $users = array();

        foreach ($bodyMembers as $member) {
            $users[] = (new User())->loadData($member);
        }

        return $users;
    }

}
