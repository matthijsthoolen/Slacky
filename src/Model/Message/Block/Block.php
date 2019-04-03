<?php

namespace MatthijsThoolen\Slacky\Model\Message\Block;

use JsonSerializable;

/**
 * Class Block
 *
 * @package Messages
 */
abstract class Block implements JsonSerializable
{
    /** @var string */
    protected $block_id;

    /** @var string */
    protected $type;

    /**
     * @return array
     */
    abstract public function jsonSerialize() : array;
}
