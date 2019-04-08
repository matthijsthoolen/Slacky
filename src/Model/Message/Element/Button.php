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