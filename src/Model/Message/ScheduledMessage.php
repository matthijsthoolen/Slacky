<?php

namespace MatthijsThoolen\Slacky\Model\Message;

use MatthijsThoolen\Slacky\Endpoint\Chat\DeleteScheduledMessage;
use MatthijsThoolen\Slacky\Endpoint\Chat\ScheduleMessage;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Slacky;
use MatthijsThoolen\Slacky\SlackyFactory;

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
    public function getScheduledMessageId()
    {
        return $this->scheduled_message_id;
    }

    /**
     * @param $scheduledMessageId
     * @return string
     */
    public function setScheduledMessageId($scheduledMessageId)
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
     * ACTIONS
     */

    /**
     * @return bool
     * @throws SlackyException
     */
    public function send()
    {
        /** @var ScheduleMessage $scheduleMessage */
        $scheduleMessage = SlackyFactory::build(ScheduleMessage::class);
        $response        = $scheduleMessage->setMessage($this)->send();

        return $response->isOk();
    }

    /**
     * @return bool
     * @throws SlackyException
     */
    public function delete()
    {
        /** @var DeleteScheduledMessage $deleteScheduledMessage */
        $deleteScheduledMessage = SlackyFactory::build(DeleteScheduledMessage::class);
        $response               = $deleteScheduledMessage->setMessage($this)->send();

        if ($response->isOk()) {
            $this->setScheduledMessageId(null);
        }

        return $response->isOk();
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
