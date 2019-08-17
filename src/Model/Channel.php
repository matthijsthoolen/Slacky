<?php

namespace MatthijsThoolen\Slacky\Model;

use MatthijsThoolen\Slacky\Endpoint\Conversations\Info;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\SlackyFactory;

/**
 * Abstract class for all channel-like Slack models (IM, MPIM, Public Channels and Groups)
 */
abstract class Channel extends Model
{
    /** @var string */
    protected $id;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

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
        $response = $info->setConversation($this)->setIncludeNumMembers(true)->send();

        /** @noinspection PhpUndefinedMethodInspection */
        $this->loadData($response->getChannel());

        return $this;
    }
}
