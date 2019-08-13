<?php

namespace MatthijsThoolen\Slacky\Tests\Helpers;

use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Model\Message\Message;

class MessageHelper
{
    /** @var Message[] */
    private static $messages;

    /**
     * Send a message to the given channel. Will be cleaned when cleanUp is called.
     *
     * @param $channel
     * @param $text
     * @throws SlackyException
     */
    public static function sendMessage($channel, $text)
    {
        $message = new Message();
        $message
            ->setChannel($channel)
            ->setText($text)
            ->send();

        self::$messages[] = $message;
    }

    /**
     * @throws SlackyException
     */
    public static function cleanUp()
    {
        foreach (self::$messages as $message) {
            $message->delete();
        }
    }
}
