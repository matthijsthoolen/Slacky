<?php

namespace MatthijsThoolen\Slacky\Model\Message;

use JsonSerializable;
use MatthijsThoolen\Slacky\Model\Message\Block\Block;
use MatthijsThoolen\Slacky\Model\Model;
use MatthijsThoolen\Slacky\Slacky;

class EphemeralMessage extends BaseMessage
{
    /** @var string */
    private $ts;

    /** @var string */
    private $user;

    /**
     * EphemeralMessage constructor.
     * @param Slacky|null $slacky
     */
    public function __construct(Slacky $slacky = null)
    {
        parent::__construct($slacky);

        $this->allowedProperties[] = 'ts';
        $this->allowedProperties[] = 'user';
    }

    /**
     * @return string
     */
    public function getTs(): string
    {
        return $this->ts;
    }

    /**
     * @param string $ts
     *
     * @return $this
     */
    public function setTs(string $ts)
    {
        $this->ts = $ts;

        return $this;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @param string $user
     *
     * @return $this
     */
    public function setUser(string $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        $data = parent::jsonSerialize();

        $data['user'] = $this->user;

        if ($this->ts !== null) {
            $data['ts'] = $this->ts;
        }

        return $data;
    }
}
