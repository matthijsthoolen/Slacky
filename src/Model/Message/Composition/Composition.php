<?php

namespace MatthijsThoolen\Slacky\Model\Message\Composition;

use JsonSerializable;

/**
 * Class Composition
 *
 * @documentation https://api.slack.com/reference/messaging/composition-objects#text
 */
abstract class Composition implements JsonSerializable
{
    /** @var string */
    protected $type;

    /**
     * @return string
     */
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * @return array
     */
    abstract public function jsonSerialize() : array;
}
