<?php

namespace MatthijsThoolen\Slacky\Model\Message\Element;

use JsonSerializable;

/**
 * Class Element
 *
 * @package MatthijsThoolen\Slacky\Model\Message\Elements
 */
abstract class Element implements JsonSerializable
{
    /** @var string */
    protected $type;

    /**
     * @return array
     */
    abstract public function jsonSerialize() : array;
}
