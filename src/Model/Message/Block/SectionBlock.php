<?php

namespace MatthijsThoolen\Slacky\Model\Message\Block;

use MatthijsThoolen\Slacky\Model\Message\Composition\TextObject;
use MatthijsThoolen\Slacky\Model\Message\Element\Element;

/**
 * Class SectionBlock
 */
class SectionBlock extends Block
{
    /** @var string */
    protected $type = 'section';

    /** @var TextObject */
    protected $text;

    /** @var TextObject[] */
    protected $fields;

    /** @var Element[] */
    protected $accessory;

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
     * @return SectionBlock
     */
    public function setText($text): SectionBlock
    {
        $this->text = new TextObject();
        $this->text->setText($text);

        return $this;
    }

    public function setTextObject(TextObject $text): SectionBlock
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return TextObject[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param TextObject[] $fields
     *
     * @return SectionBlock
     */
    public function setFields(array $fields): SectionBlock
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @param TextObject $field
     *
     * @return SectionBlock
     */
    public function addField(TextObject $field): SectionBlock
    {
        $this->fields[] = $field;

        return $this;
    }

    /**
     * @return Element[]
     */
    public function getAccessory(): array
    {
        return $this->accessory;
    }

    /**
     * @param Element[] $accessory
     *
     * @return SectionBlock
     */
    public function setAccessory(array $accessory): SectionBlock
    {
        $this->accessory = $accessory;

        return $this;
    }

    /**
     * @param Element $accessory
     *
     * @return SectionBlock
     */
    public function addAccessory(Element $accessory): SectionBlock
    {
        $this->accessory[] = $accessory;

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

        // TODO: automatically add all none null values to array. Check for required fields.
        if ($this->block_id !== null) {
            $data['block_id'] = $this->block_id;
        }

        if ($this->fields !== null) {
            $data['fields'] = $this->fields;
        }

        if ($this->accessory !== null) {
            $data['accessory'] = $this->accessory;
        }

        return $data;
    }
}
