<?php

namespace MatthijsThoolen\Slacky\Endpoint\Conversations;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Model\PrivateChannel;
use MatthijsThoolen\Slacky\Model\Channel;
use MatthijsThoolen\Slacky\Model\SlackyResponse;
use MatthijsThoolen\Slacky\Model\User;

/**
 * @documentation https://api.slack.com/methods/conversations.create
 */
class Create extends Endpoint
{
    /** @var string */
    protected $method = 'POST';

    /** @var string */
    protected $uri = 'conversations.create';

    /** @var string */
    private $name;

    /** @var bool */
    private $isPrivate = false;

    /** @var array */
    private $userIds;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Create
     */
    public function setName(string $name): Create
    {
        $this->name = $this->parameters['name'] = $name;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPrivate(): bool
    {
        return $this->isPrivate;
    }

    /**
     * @param bool $isPrivate
     * @return Create
     */
    public function setIsPrivate(bool $isPrivate): Create
    {
        $this->isPrivate = $this->parameters['is_private'] = $isPrivate;
        return $this;
    }

    /**
     * @return array
     */
    public function getUserIds(): array
    {
        return $this->userIds;
    }

    /**
     * @param array $userIds
     * @return Create
     */
    public function setUserIds(array $userIds): Create
    {
        $this->userIds                = $userIds;
        $this->parameters['user_ids'] = implode(',', $userIds);
        return $this;
    }

    /**
     * @param User[] $users
     *
     * @return Create
     */
    public function setUsers(array $users): Create
    {
        $userIds = [];
        /** @var User $user */
        foreach ($users as $user) {
            $userIds[] = $user->getId();
        }
        $this->setUserIds($userIds);
        return $this;
    }

    /**
     * @param SlackyResponse $response
     * @return SlackyResponse
     * @throws SlackyException
     */
    public function handleResponse(SlackyResponse $response)
    {
        parent::handleResponse($response);

        /** @noinspection PhpUndefinedMethodInspection */
        $channel = $response->getChannel();

        if ($channel['is_private'] === false) {
            $channelObject = new Channel();
        } else {
            $channelObject = new PrivateChannel();
        }

        $channelObject->loadData($channel);

        $response->setObject($channelObject);

        return $response;
    }
}
