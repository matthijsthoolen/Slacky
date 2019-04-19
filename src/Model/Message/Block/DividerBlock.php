<?php

namespace MatthijsThoolen\Slacky\Model\Message\Block;

/**
 * Class DividerBlock
 *
 * @package MatthijsThoolen\Slacky\Model\Message
 */
class DividerBlock extends Block
{
    /** @var string */
    protected $tye = 'divider';

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $data = [
            'type' => $this->type
        ];

        if ($this->block_id !== null) {
            $data['block_id'] = $this->block_id;
        }

        return $data;
    }
}
