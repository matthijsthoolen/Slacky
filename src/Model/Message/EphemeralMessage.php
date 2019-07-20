<?php

namespace MatthijsThoolen\Slacky\Model\Message;

use MatthijsThoolen\Slacky\Model\Message\Block\Block;
use MatthijsThoolen\Slacky\Model\Model;

class EphemeralMessage extends Model implements \JsonSerializable
{
    /** @var string */
    private $channel;

    /** @var string */
    private $text;

    /** @var string */
    private $user;

    /** @var bool */
    private $as_user;

    /** @var attachment[] */
    private $attachments = [];

    /** @var block[] */
    private $blocks = [];

    /** @var bool */
    private $link_names;

    /** @var string */
    private $parse = 'none';

    /** @var string */
    private $thread_ts;

    /** @var array */
    protected $allowedProperties = [
        'channel',
        'text',
        'user',
        'as_user',
        'attachments',
        'blocks',
        'link_names',
        'parse',
        'thread_ts'
    ];

    /**
     * @return string
     */
    public function getChannel(): string
    {
        return $this->channel;
    }

    /**
     * @param string $channel
     * @return EphemeralMessage
     */
    public function setChannel(string $channel): EphemeralMessage
    {
        $this->channel = $channel;
        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return EphemeralMessage
     */
    public function setText(string $text): EphemeralMessage
    {
        $this->text = $text;
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
     * @return EphemeralMessage
     */
    public function setUser(string $user): EphemeralMessage
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAsUser(): bool
    {
        return $this->as_user;
    }

    /**
     * @param bool $as_user
     * @return EphemeralMessage
     */
    public function setAsUser(bool $as_user): EphemeralMessage
    {
        $this->as_user = $as_user;
        return $this;
    }

    /**
     * @return attachment[]
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    /**
     * @param attachment[] $attachments
     * @return EphemeralMessage
     */
    public function setAttachments(array $attachments): EphemeralMessage
    {
        $this->attachments = $attachments;
        return $this;
    }

    /**
     * @return Block[]
     */
    public function getBlocks(): array
    {
        return $this->blocks;
    }

    /**
     * @param Block[] $blocks
     * @return EphemeralMessage
     */
    public function setBlocks(array $blocks): EphemeralMessage
    {
        $this->blocks = $blocks;
        return $this;
    }

    /**
     * @return bool
     */
    public function isLinkNames(): bool
    {
        return $this->link_names;
    }

    /**
     * @param bool $link_names
     * @return EphemeralMessage
     */
    public function setLinkNames(bool $link_names): EphemeralMessage
    {
        $this->link_names = $link_names;
        return $this;
    }

    /**
     * @return string
     */
    public function getParse(): string
    {
        return $this->parse;
    }

    /**
     * @param string $parse
     * @return EphemeralMessage
     */
    public function setParse(string $parse): EphemeralMessage
    {
        $this->parse = $parse;
        return $this;
    }

    /**
     * @return string
     */
    public function getThreadTs(): string
    {
        return $this->thread_ts;
    }

    /**
     * @param string $thread_ts
     * @return EphemeralMessage
     */
    public function setThreadTs(string $thread_ts): EphemeralMessage
    {
        $this->thread_ts = $thread_ts;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        $data = [
            'channel' => $this->channel,
            'user'    => $this->user
        ];

        if (count($this->blocks) > 0) {
            $data['blocks'] = $this->blocks;
        }

        if ($this->text !== null) {
            $data['text'] = $this->text;
        }

        if (count($this->attachments) > 0) {
            $data['attachments'] = $this->attachments;
        }

        if ($this->as_user !== null) {
            $data['as_user'] = $this->as_user;
        }

        if ($this->link_names !== null) {
            $data['link_names'] = $this->link_names;
        }

        if ($this->parse !== null) {
            $data['parse'] = $this->parse;
        }

        if ($this->thread_ts !== null) {
            $data['thread_ts'] = $this->thread_ts;
        }

        return $data;
    }
}
