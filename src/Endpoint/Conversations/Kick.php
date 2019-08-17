<?php

namespace MatthijsThoolen\Slacky\Endpoint\Conversations;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\Channel;
use MatthijsThoolen\Slacky\Model\User;

/**
 * @documentation https://api.slack.com/methods/conversations.join
 */
class Kick extends Endpoint
{
    /** @var string */
    protected $method = 'POST';

    /** @var string */
    protected $uri = 'conversations.kick';

    /** @var Channel */
    protected $channel;

    /** @var User */
    protected $user;

    /**
     * @return Channel
     */
    public function getChannel(): Channel
    {
        return $this->channel;
    }

    /**
     * @param Channel $channel
     * @return Kick
     */
    public function setChannel(Channel $channel): Kick
    {
        $this->channel               = $channel;
        $this->parameters['channel'] = $channel->getId();
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Kick
     */
    public function setUser(User $user): Kick
    {
        $this->user = $user;
        $this->parameters['user'] = $user->getId();
        return $this;
    }
}
