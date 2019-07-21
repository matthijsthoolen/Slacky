<?php

namespace MatthijsThoolen\Slacky\Model\Message;

use function array_filter;
use function is_null;
use JsonSerializable;
use MatthijsThoolen\Slacky\Model\Message\Block\Block;
use MatthijsThoolen\Slacky\Model\Model;

abstract class BaseMessage extends Model implements JsonSerializable
{
    /** @var string */
    private $channel;

    /** @var string */
    private $text;

    /** @var bool */
    private $as_user = false;

    /** @var Attachment[] */
    private $attachments = array();

    /** @var Block[] */
    private $blocks = array();

    /** @var string */
    private $icon_emoji;

    /** @var string */
    private $icon_url;

    /** @var bool */
    private $link_names;

    /** @var bool */
    private $mrkdwn = false;

    /** @var string */
    private $parse = 'none';

    /** @var bool */
    private $reply_broadcast = false;

    /** @var string */
    private $thread_ts;

    /** @var bool */
    private $unfurl_links = false;

    /** @var bool */
    private $unfurl_media = false;

    /** @var string */
    private $username;

    protected $allowedProperties = [
        'channel',
        'text',
        'as_user',
        'attachments',
        'blocks',
        'icon_emoji',
        'icon_url',
        'link_names',
        'mrkdwn',
        'parse',
        'reply_broadcast',
        'thread_ts',
        'unfurl_links',
        'unfurl_media',
        'username'
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
     *
     * @return $this
     */
    public function setChannel(string $channel)
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * Only use text as fallback for the new Slack Blocks.
     *
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return $this
     */
    public function setText(string $text)
    {
        $this->text = $text;

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
     *
     * @return $this
     */
    public function setAsUser(bool $as_user)
    {
        $this->as_user = $as_user;

        return $this;
    }

    /**
     * @return Attachment[]
     * @deprecated please use blocks instead
     */
    public function getAttachments(): string
    {
        return $this->attachments;
    }

    /**
     * @param Attachment[] $attachments
     *
     * @return $this
     * @deprecated please use blocks instead
     */
    public function setAttachments(array $attachments)
    {
        $this->attachments = $attachments;

        return $this;
    }

    /**
     * @param Attachment $attachment
     *
     * @return $this
     * @deprecated please use blocks instead
     */
    public function addAttachment(Attachment $attachment)
    {
        $this->attachments[] = $attachment;

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
     *
     * @return $this
     */
    public function setBlocks(array $blocks)
    {
        $this->blocks = $blocks;

        return $this;
    }

    /**
     * @param Block $block
     *
     * @return $this
     */
    public function addBlock(Block $block)
    {
        $this->blocks[] = $block;

        return $this;
    }

    /**
     * @return string
     */
    public function getIconEmoji(): string
    {
        return $this->icon_emoji;
    }

    /**
     * @param string $icon_emoji
     *
     * @return $this
     */
    public function setIconEmoji(string $icon_emoji)
    {
        $this->icon_emoji = $icon_emoji;

        return $this;
    }

    /**
     * @return string
     */
    public function getIconUrl(): string
    {
        return $this->icon_url;
    }

    /**
     * @param string $icon_url
     *
     * @return $this
     */
    public function setIconUrl(string $icon_url)
    {
        $this->icon_url = $icon_url;

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
     *
     * @return $this
     */
    public function setLinkNames(bool $link_names)
    {
        $this->link_names = $link_names;

        return $this;
    }

    /**
     * @return bool
     */
    public function isMrkdwn(): bool
    {
        return $this->mrkdwn;
    }

    /**
     * @param bool $mrkdwn
     *
     * @return $this
     */
    public function setMrkdwn(bool $mrkdwn)
    {
        $this->mrkdwn = $mrkdwn;

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
     *
     * @return $this
     */
    public function setParse(string $parse)
    {
        $this->parse = $parse;

        return $this;
    }

    /**
     * @return bool
     */
    public function isReplyBroadcast(): bool
    {
        return $this->reply_broadcast;
    }

    /**
     * @param bool $reply_broadcast
     *
     * @return $this
     */
    public function setReplyBroadcast(bool $reply_broadcast)
    {
        $this->reply_broadcast = $reply_broadcast;

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
     *
     * @return $this
     */
    public function setThreadTs(string $thread_ts)
    {
        $this->thread_ts = $thread_ts;

        return $this;
    }

    /**
     * @return bool
     */
    public function isUnfurlLinks(): bool
    {
        return $this->unfurl_links;
    }

    /**
     * @param bool $unfurl_links
     *
     * @return $this
     */
    public function setUnfurlLinks(bool $unfurl_links)
    {
        $this->unfurl_links = $unfurl_links;

        return $this;
    }

    /**
     * @return bool
     */
    public function isUnfurlMedia(): bool
    {
        return $this->unfurl_media;
    }

    /**
     * @param bool $unfurl_media
     *
     * @return $this
     */
    public function setUnfurlMedia(bool $unfurl_media)
    {
        $this->unfurl_media = $unfurl_media;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return $this
     */
    public function setUsername(string $username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        $data = [
            'channel'         => $this->channel,
            'as_user'         => $this->as_user,
            'icon_emoji'      => $this->icon_emoji,
            'icon_url'        => $this->icon_url,
            'link_names'      => $this->link_names,
            'mrkdwn'          => $this->mrkdwn,
            'parse'           => $this->parse,
            'reply_broadcast' => $this->reply_broadcast,
            'thread_ts'       => $this->thread_ts,
            'unfurl_links'    => $this->unfurl_links,
            'unfurl_media'    => $this->unfurl_media,
            'username'        => $this->username
        ];

        // Remove null values from array
        $data = array_filter(
            $data,
            function ($var) {
                return !is_null($var);
            }
        );

        if (count($this->blocks) > 0) {
            $data['blocks'] = $this->blocks;
        }

        if ($this->text !== null) {
            $data['text'] = $this->text;
        } else {
            $blocks = $this->getBlocks();
            if (count($blocks) > 0) {
                $data['text'] = $blocks[0]->getText();
            }
        }

        if (count($this->attachments) > 0) {
            $data['attachments'] = $this->attachments;
        }

        return $data;
    }
}
