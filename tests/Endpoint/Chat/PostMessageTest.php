<?php

namespace MatthijsThoolen\Slacky\Tests\Endpoint\Chat;

use function getenv;
use MatthijsThoolen\Slacky\Endpoint\Chat\PostMessage;
use MatthijsThoolen\Slacky\Slacky;
use MatthijsThoolen\Slacky\SlackyFactory;
use PHPUnit\Framework\TestCase;

class PostMessageTest extends TestCase
{

    /**
     *
     * @throws \Exception
     */
    public function testSetMessage()
    {
        $slackToken = getenv('SLACK_BOT_TOKEN');
        new Slacky($slackToken);

        /** @var PostMessage $postMessage */
        $postMessage = SlackyFactory::build(PostMessage::class);
        self::assertInstanceOf(PostMessage::class, $postMessage);

        $response = $postMessage->setMessage();
    }

}
