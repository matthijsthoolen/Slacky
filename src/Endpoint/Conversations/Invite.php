<?php

namespace MatthijsThoolen\Slacky\Endpoint\Conversations;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\Channel;
use MatthijsThoolen\Slacky\Model\User;

/**
 * @documentation https://api.slack.com/methods/conversations.invite
 */
class Invite extends Endpoint
{
    /** @var string */
    protected $method = 'POST';

    /** @var string */
    protected $uri = 'conversations.invite';

    /** @var Channel */
    protected $channel;

    /** @var User[] */
    protected $users;

    /**
     * @return Channel
     */
    public function getChannel(): Channel
    {
        return $this->channel;
    }

    /**
     * @param Channel $channel
     * @return Invite
     */
    public function setChannel(Channel $channel): Invite
    {
        $this->channel               = $channel;
        $this->parameters['channel'] = $channel->getId();
        return $this;
    }

    /**
     * @return User[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }

    /**
     * @param User[] $users
     * @return Invite
     */
    public function setUsers(array $users): Invite
    {
        $this->users = $users;

        $userIds = [];
        foreach ($users as $user) {
            $userIds[] = $user->getId();
        }

        $this->parameters['users'] = implode(',', $userIds);
        return $this;
    }
}
