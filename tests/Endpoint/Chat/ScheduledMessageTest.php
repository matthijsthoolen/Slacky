<?php

namespace MatthijsThoolen\Slacky\Tests\Endpoint\Chat;

use function getenv;
use MatthijsThoolen\Slacky\Endpoint\Chat\PostMessage;
use MatthijsThoolen\Slacky\Endpoint\Chat\ScheduleMessage;
use MatthijsThoolen\Slacky\Model\Message\Message;
use MatthijsThoolen\Slacky\Model\SlackyResponse;
use MatthijsThoolen\Slacky\Slacky;
use MatthijsThoolen\Slacky\SlackyFactory;
use PHPUnit\Framework\TestCase;

class ScheduledMessageTest extends TestCase
{
    public function testScheduleMessage()
    {
        $slackToken = getenv('SLACK_BOT_TOKEN');
        new Slacky($slackToken);

        /** @var PostMessage $postMessage */
        $postMessage = SlackyFactory::build(ScheduleMessage::class);
        self::assertInstanceOf(ScheduleMessage::class, $postMessage);

        $message = new Message();
        $message->setChannel(getenv('SLACK_PHPUNIT_CHANNEL'));
        $message->setPostAt(time() + 15);
        $message->setText('A unit test scheduled for the future!');

        $response = $postMessage->setMessage($message)->send();
        self::assertInstanceOf(SlackyResponse::class, $response);
        self::assertSame(200, $response->getStatusCode());

        $body = $response->getBody();
        self::assertNotNull($body['scheduled_message_id']);
        self::assertTrue($response->isOk());
        self::assertEquals('OK', $response->getError());

        return $message;
    }
}
