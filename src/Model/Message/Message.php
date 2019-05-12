<?php

namespace MatthijsThoolen\Slacky\Model\Message;

use JsonSerializable;
use MatthijsThoolen\Slacky\Model\Message\Block\Block;
use MatthijsThoolen\Slacky\Model\Model;

/**
 * Class Message
 */
class Message extends Model implements JsonSerializable
{
    /** @var string */
    private $ts;

    /** @var string */
    private $channel;

    /** @var string */
    private $text;

    /** @var bool */
    private $as_user = false;

    /** @var Attachment[] */
    private $attachments;

    /** @var Block[] */
    private $blocks;

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
        'ts',
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
    public function getTs(): string
    {
        return $this->ts;
    }

    /**
     * @param string $ts
     *
     * @return Message
     */
    public function setTs(string $ts): Message
    {
        $this->ts = $ts;

        return $this;
    }

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
     * @return Message
     */
    public function setChannel(string $channel): Message
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
     * @return Message
     */
    public function setText(string $text): Message
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
     * @return Message
     */
    public function setAsUser(bool $as_user): Message
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
     * @return Message
     * @deprecated please use blocks instead
     */
    public function setAttachments(array $attachments): Message
    {
        $this->attachments = $attachments;

        return $this;
    }

    /**
     * @param Attachment $attachment
     *
     * @return Message
     * @deprecated please use blocks instead
     */
    public function addAttachment(Attachment $attachment): Message
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
     * @return Message
     */
    public function setBlocks(array $blocks): Message
    {
        $this->blocks = $blocks;

        return $this;
    }

    /**
     * @param Block $block
     *
     * @return Message
     */
    public function addBlock(Block $block): Message
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
     * @return Message
     */
    public function setIconEmoji(string $icon_emoji): Message
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
     * @return Message
     */
    public function setIconUrl(string $icon_url): Message
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
     * @return Message
     */
    public function setLinkNames(bool $link_names): Message
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
     * @return Message
     */
    public function setMrkdwn(bool $mrkdwn): Message
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
     * @return Message
     */
    public function setParse(string $parse): Message
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
     * @return Message
     */
    public function setReplyBroadcast(bool $reply_broadcast): Message
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
     * @return Message
     */
    public function setThreadTs(string $thread_ts): Message
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
     * @return Message
     */
    public function setUnfurlLinks(bool $unfurl_links): Message
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
     * @return Message
     */
    public function setUnfurlMedia(bool $unfurl_media): Message
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
     * @return Message
     */
    public function setUsername(string $username): Message
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
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
        $data = array_filter($data, function($var){return !is_null($var);});

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
