<?php

namespace MatthijsThoolen\Slacky\Model\Message\Block;

use MatthijsThoolen\Slacky\Model\Message\Composition\TextObject;

/**
 * Class ImageBlock
 */
class ImageBlock extends Block
{
    /** @var string */
    protected $type = 'image';

    /** @var string */
    protected $image_url;

    /** @var string */
    protected $alt_text;

    /** @var TextObject */
    protected $title;

    /**
     * @return string
     */
    public function getImageUrl(): string
    {
        return $this->image_url;
    }

    /**
     * @param string $image_url
     *
     * @return ImageBlock
     */
    public function setImageUrl(string $image_url): ImageBlock
    {
        $this->image_url = $image_url;

        return $this;
    }

    /**
     * @return string
     */
    public function getAltText(): string
    {
        return $this->alt_text;
    }

    /**
     * @param string $alt_text
     *
     * @return ImageBlock
     */
    public function setAltText(string $alt_text): ImageBlock
    {
        $this->alt_text = $alt_text;

        return $this;
    }

    /**
     * @return TextObject
     */
    public function getTitle(): TextObject
    {
        return $this->title;
    }

    /**
     * @param TextObject $title
     *
     * @return ImageBlock
     */
    public function setTitle(TextObject $title): ImageBlock
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'block_id'  => $this->block_id,
            'type'      => $this->type,
            'image_url' => $this->image_url,
            'alt_text'  => $this->alt_text,
            'title'     => $this->title,
        ];
    }
}
