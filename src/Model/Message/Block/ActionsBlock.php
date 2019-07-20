<?php

namespace MatthijsThoolen\Slacky\Model\Message\Block;

use MatthijsThoolen\Slacky\Model\Message\Element\Element;

/**
 * Class ActionsBlock
 *
 * @package MatthijsThoolen\Slacky\Model\Message
 */
class ActionsBlock extends Block
{
    /** @var string */
    protected $type = 'actions';

    /** @var Element[] */
    protected $elements;

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
     * @return ActionsBlock
     */
    public function setElements(array $elements): ActionsBlock
    {
        $this->elements = $elements;

        return $this;
    }

    /**
     * @param Element $element
     *
     * @return ActionsBlock
     */
    public function addElement(Element $element): ActionsBlock
    {
        $this->elements[] = $element;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $data = [
            'type'     => $this->type,
            'elements' => $this->elements
        ];

        if ($this->block_id !== null) {
            $data['block_id'] = $this->block_id;
        }

        return $data;
    }
}
