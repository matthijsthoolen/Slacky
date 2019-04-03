<?php

namespace MatthijsThoolen\Slacky\Model\Message\Block;

use MatthijsThoolen\Slacky\Model\Message\Element\Element;

/**
 * Class ContextBlock
 *
 * @package MatthijsThoolen\Slacky\Model\Message
 */
class ContextBlock extends Block
{
    /** @var string */
    protected $type = 'context';

    /** @var Element[] */
    protected $elements = [];

    /**
     * @return Element[]
     */
    public function getElements(): array
    {
        return $this->elements;
    }

    /**
     * @param Element[] $elements
     *
     * @return ContextBlock
     */
    public function setElements(array $elements): ContextBlock
    {
        $this->elements = $elements;

        return $this;
    }

    /**
     * @param Element $element
     *
     * @return ContextBlock
     */
    public function addElement(Element $element): ContextBlock
    {
        $this->elements[] = $element;

        return $this;
    }

    public function jsonSerialize() : array
    {
        return [
            'block_id'  => $this->block_id,
            'type' => $this->type,
            'elements' => $this->elements
        ];
    }
}
