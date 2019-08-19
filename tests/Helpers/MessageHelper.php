<?php

namespace MatthijsThoolen\Slacky\Tests\Helpers;

use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Model\Conversation;
use MatthijsThoolen\Slacky\Model\Message\Message;

class MessageHelper
{
    /** @var Message[] */
    private static $messages = [];

    /**
     * Send a message to the given channel. Will be cleaned when cleanUp is called.
     *
     * @param Conversation $conversation
     * @param string $text
     *
     * @return Message
     * @throws SlackyException
     */
    public static function sendMessage(Conversation $conversation, $text)
    {
        $message = new Message();
        $message
            ->setChannel($conversation->getId())
            ->setText($text)
            ->send();

        self::$messages[] = $message;

        return $message;
    }

    /**
     * Remove all messages
     */
    public static function cleanUp()
    {
        foreach (self::$messages as $message) {
            try {
                $message->delete();
            } catch (SlackyException $e) {
                continue;
            }
        }
    }
}
