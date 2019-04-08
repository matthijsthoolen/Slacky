<?php

namespace MatthijsThoolen\Slacky\Model\Message\Element;

use MatthijsThoolen\Slacky\Model\Message\Composition\TextObject;

/**
 * Class Button
 *
 * @package MatthijsThoolen\Slacky\Model\Message\Element
 */
class Button extends Element
{

    /** @var string */
    protected $type = 'button';

    /** @var TextObject */
    protected $text;

    /** @var string */
    protected $url;

    /**
     * @return TextObject
     */
    public function getText(): TextObject
    {
        return $this->text;
    }

    /**
     * Set the text, a textobject is automatically generated
     *
     * @param TextObject|string $text
     *
     * @return Button
     */
    public function setText($text): Button
    {
        $this->text = new TextObject();
        $this->text->setText($text);

        return $this;
    }

    /**
     * @param TextObject $text
     *
     * @return Button
     */
    public function setTextObject(TextObject $text): Button
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return Button
     */
    public function setUrl(string $url): Button
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $data = [
            'type' => $this->type,
            'text' => $this->text
        ];

        if ($this->url !== null) {
            $data['url'] = $this->url;
        }

        return $data;
    }
}