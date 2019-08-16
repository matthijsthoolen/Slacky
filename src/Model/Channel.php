<?php

namespace MatthijsThoolen\Slacky\Model;

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
}
