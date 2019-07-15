<?php

namespace MatthijsThoolen\Slacky\Tests\Endpoint\Chat;

use function getenv;
use MatthijsThoolen\Slacky\Endpoint\Chat\PostEphemeral;
use MatthijsThoolen\Slacky\Endpoint\Chat\PostMessage;
use MatthijsThoolen\Slacky\Model\Message\Message;
use MatthijsThoolen\Slacky\Model\SlackyResponse;
use MatthijsThoolen\Slacky\Slacky;
use MatthijsThoolen\Slacky\SlackyFactory;
use PHPUnit\Framework\TestCase;

class EphemeralMessageTest extends TestCase
{
    public function testSendEphemeralMessage()
    {
        $slackToken = getenv('SLACK_BOT_TOKEN');
        new Slacky($slackToken);

        /** @var PostMessage $postMessage */
        $postMessage = SlackyFactory::build(PostEphemeral::class);
        self::assertInstanceOf(PostEphemeral::class, $postMessage);

        $message = new Message();
        $message->setChannel(getenv('SLACK_PHPUNIT_CHANNEL'));
        $message->setUser(getenv('SLACK_PHPUNIT_USER'));
        $message->setText('Unit test Ephemeral message');

        $response = $postMessage->setMessage($message)->send();
        self::assertInstanceOf(SlackyResponse::class, $response);
        self::assertSame(200, $response->getStatusCode());

        $message = $response->getObject();
        self::assertInstanceOf(Message::class, $message);
        self::assertNotNull($message->getTs());
        self::assertTrue($response->isOk());
        self::assertEquals('OK', $response->getError());

        return $message;
    }
}
