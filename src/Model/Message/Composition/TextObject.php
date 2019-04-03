<?php

namespace MatthijsThoolen\Slacky\Model\Message\Composition;

/**
 * Class TextObject
 */
class TextObject extends Composition
{
    /** @var string */
    protected $type = 'plain_text';

    /** @var string */
    protected $text;

    /** @var bool */
    protected $emoji = true;

    /** @var bool */
    protected $verbatim = false;

    /**
     * @param bool $markdown
     */
    public function __construct($markdown = false)
    {
        if ($markdown === true) {
            $this->type = 'mrkdwn';
        }
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
     *
     * @return TextObject
     */
    public function setText(string $text): TextObject
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEmoji(): bool
    {
        return $this->emoji;
    }

    /**
     * This field is only usable if $type is plain_text
     *
     * @param bool $emoji
     *
     * @return TextObject
     */
    public function setEmoji(bool $emoji): TextObject
    {
        $this->emoji = $emoji;

        return $this;
    }

    /**
     * @return bool
     */
    public function isVerbatim(): bool
    {
        return $this->verbatim;
    }

    /**
     * This field is only usable when type is mrkdwn.
     *
     * @param bool $verbatim
     *
     * @return TextObject
     */
    public function setVerbatim(bool $verbatim): TextObject
    {
        $this->verbatim = $verbatim;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $data = [];

        if ($this->type === 'plain_text') {
            $data['emoji'] = $this->emoji;
        }

        if ($this->type === 'mrkdwn') {
            $data['verbatim'] = $this->verbatim;
        }

        $data['type'] = $this->type;
        $data['text'] = $this->text;

        return $data;
    }
}
