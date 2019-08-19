<?php

namespace MatthijsThoolen\Slacky\Model;

use MatthijsThoolen\Slacky\Endpoint\Conversations\Create;
use MatthijsThoolen\Slacky\Endpoint\Conversations\Info;
use MatthijsThoolen\Slacky\Endpoint\Conversations\Members;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\SlackyFactory;

/**
 * Abstract class for all channel-like Slack models (IM, MPIM, Public Channels and Groups)
 */
abstract class Conversation extends Model
{
    /** @var string */
    protected $id;

    /** @var array */
    protected $members;

    /** @var array */
    protected $allowedProperties = array(
        'id',
        'members'
    );

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return User[]
     * @throws SlackyException
     */
    public function getMembers()
    {
        if ($this->members !== null) {
            return $this->members;
        }

        $membersEndpoint = SlackyFactory::make(Members::class);
        $response        = $membersEndpoint->setChannel($this)->send();

        $this->members = $response->getObject();
        return $this->members;
    }

    /**
     * @param User[] $members
     *
     * @return $this
     */
    public function setMembers(array $members)
    {
        $this->members = $members;
        return $this;
    }

    /** ACTIONS */

    /**
     * @return $this
     *
     * @throws SlackyException
     */
    public function refreshInfo()
    {
        $info     = SlackyFactory::make(Info::class);
        $response = $info
            ->setConversation($this)
            ->setIncludeNumMembers(true)
            ->send();

        /** @noinspection PhpUndefinedMethodInspection */
        $this->loadData($response->getChannel());

        return $this;
    }
}
