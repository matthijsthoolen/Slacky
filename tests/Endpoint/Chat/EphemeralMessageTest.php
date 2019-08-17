<?php

namespace MatthijsThoolen\Slacky\Tests\Endpoint\Chat;

use MatthijsThoolen\Slacky\Endpoint\Chat\PostEphemeral;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Model\Message\EphemeralMessage;
use MatthijsThoolen\Slacky\Model\SlackyResponse;
use MatthijsThoolen\Slacky\Slacky;
use MatthijsThoolen\Slacky\SlackyFactory;
use PHPUnit\Framework\TestCase;
use function getenv;

class EphemeralMessageTest extends TestCase
{
    /**
     * @return EphemeralMessage|Object|Object[]
     * @throws SlackyException
     */
    public function testSendEphemeralMessage()
    {
        $slackToken = getenv('SLACK_BOT_TOKEN');
        new Slacky($slackToken);

        /** @var PostEphemeral $postMessage */
        $postMessage = SlackyFactory::make(PostEphemeral::class);
        self::assertInstanceOf(PostEphemeral::class, $postMessage);

        $message = new EphemeralMessage();
        $message->setChannel(getenv('SLACK_PHPUNIT_CHANNEL'));
        $message->setUser(getenv('SLACK_PHPUNIT_USER'));
        $message->setText('Unit test Ephemeral message');

        $response = $postMessage->setMessage($message)->send();
        self::assertInstanceOf(SlackyResponse::class, $response);
        self::assertSame(200, $response->getStatusCode());

        $message = $response->getObject();
        self::assertInstanceOf(EphemeralMessage::class, $message);
        self::assertNotNull($message->getTs());
        self::assertTrue($response->isOk());
        self::assertEquals('OK', $response->getError());

        return $message;
    }
}
