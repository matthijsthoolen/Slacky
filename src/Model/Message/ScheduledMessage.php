<?php

namespace MatthijsThoolen\Slacky\Model\Message;

use MatthijsThoolen\Slacky\Slacky;

class ScheduledMessage extends BaseMessage
{
    /** @var string */
    private $scheduled_message_id;

    /** @var int */
    private $post_at;

    public function __construct(Slacky $slacky = null)
    {
        parent::__construct($slacky);

        $this->allowedProperties[] = 'scheduled_message_id';
        $this->allowedProperties[] = 'post_at';
    }

    /**
     * @return string
     */
    public function getScheduledMessageId(): string
    {
        return $this->scheduled_message_id;
    }

    /**
     * @param $scheduledMessageId
     * @return string
     */
    public function setScheduledMessageId($scheduledMessageId): string
    {
        $this->scheduled_message_id = $scheduledMessageId;

        return $this;
    }

    /**
     * @return int
     */
    public function getPostAt(): int
    {
        return $this->post_at;
    }

    /**
     * @param int $post_at
     * @return $this
     */
    public function setPostAt(int $post_at)
    {
        $this->post_at = $post_at;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $data = parent::jsonSerialize();

        $data['post_at'] = $this->post_at;

        if ($this->scheduled_message_id !== null) {
            $data['scheduled_message_id'] = $this->scheduled_message_id;
        }

        return $data;
    }
}
