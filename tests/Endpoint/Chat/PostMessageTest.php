<?php

namespace MatthijsThoolen\Slacky\Tests\Endpoint\Chat;

use Exception;
use function getenv;
use GuzzleHttp\Exception\GuzzleException;
use MatthijsThoolen\Slacky\Endpoint\Chat\Delete;
use MatthijsThoolen\Slacky\Endpoint\Chat\getPermalink;
use MatthijsThoolen\Slacky\Endpoint\Chat\PostMessage;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Model\Message\Message;
use MatthijsThoolen\Slacky\Model\SlackyResponse;
use MatthijsThoolen\Slacky\Slacky;
use MatthijsThoolen\Slacky\SlackyFactory;
use PHPUnit\Framework\TestCase;

class PostMessageTest extends TestCase
{

    /**
     * Test if a message is send successfully
     *
     * @covers \MatthijsThoolen\Slacky\Model\Message\Message
     * @covers \MatthijsThoolen\Slacky\Endpoint\Chat\PostMessage
     * @throws Exception
     * @throws GuzzleException
     */
    public function testSendMessage()
    {
        $slackToken = getenv('SLACK_BOT_TOKEN');
        new Slacky($slackToken);

        /** @var PostMessage $postMessage */
        $postMessage = SlackyFactory::build(PostMessage::class);
        self::assertInstanceOf(PostMessage::class, $postMessage);

        $message = new Message();
        $message->setChannel(getenv('SLACK_PHPUNIT_CHANNEL'));
        $message->setText('Unit test testSendMessage');

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

    /**
     * @depends testSendMessage
     * @param Message $message
     * @return Message
     */
    public function testGetPermalink(Message $message)
    {
        /** @var getPermalink $getPermalink */
        $getPermalink = SlackyFactory::build(getPermalink::class);
        self::assertInstanceOf(getPermalink::class, $getPermalink);

        $permalink = $getPermalink
            ->setMessageTs($message->getTs())
            ->setChannel($message->getChannel())
            ->send();

        return $message;
    }

    /**
     * - First remove the message with the delete option available in the message class
     * - Then check if the message is really removed
     *
     * @covers  \MatthijsThoolen\Slacky\Endpoint\Chat\Delete
     * @covers  \MatthijsThoolen\Slacky\Model\Message\Message::delete
     * @depends testGetPermalink
     * @param Message $message
     * @throws Exception
     * @throws GuzzleException
     */
    public function testDeleteMessage(Message $message)
    {
        self::assertTrue($message->delete());

        /** @var Delete $deleteMessage */
        $deleteMessage = SlackyFactory::build(Delete::class);
        self::assertInstanceOf(Delete::class, $deleteMessage);

        try {
            $deleteMessage->setMessage($message)->send();
            $this->fail('The previous code should have thrown an SlackyException');
        } catch (SlackyException $e) {
            $slackyResponse = $e->getSlackyResponse();
            self::assertInstanceOf(SlackyResponse::class, $slackyResponse);
            self::assertFalse($slackyResponse->isOk());
            self::assertEquals('message_not_found', $slackyResponse->getError());
        }
    }

}
