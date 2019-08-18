<?php

namespace MatthijsThoolen\Slacky\Endpoint\Conversations;

use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Helpers\Traits\Cursor;
use MatthijsThoolen\Slacky\Model\Conversation;
use MatthijsThoolen\Slacky\Model\SlackyResponse;
use MatthijsThoolen\Slacky\Model\User;

/**
 * @documentation https://api.slack.com/methods/conversations.members
 */
class Members extends Endpoint
{
    use Cursor;

    /** @var string */
    protected $method = 'GET';

    /** @var string */
    protected $uri = 'conversations.members';

    /** @var Conversation */
    private $channel;

    /**
     * @return Conversation
     */
    public function getChannel(): Conversation
    {
        return $this->channel;
    }

    /**
     * @param Conversation $channel
     *
     * @return $this
     */
    public function setChannel(Conversation $channel): Members
    {
        $this->channel = $channel;

        $this->parameters['channel'] = $channel->getId();
        return $this;
    }

    /**
     * @param SlackyResponse $response
     *
     * @return SlackyResponse
     * @throws SlackyException
     */
    public function handleResponse(SlackyResponse $response)
    {
        parent::handleResponse($response);

        if ($response->getNextCursor()) {
            $this->setCursor($response->getNextCursor());
        }

        $members = [];
        /** @noinspection PhpUndefinedMethodInspection */
        foreach ($response->getMembers() as $member) {
            $members[] = (new User())->setId($member);
        }

        $response->setObject($members);

        return $response;
    }
}
