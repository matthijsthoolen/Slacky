<?php

namespace MatthijsThoolen\Slacky\Tests\Endpoint\Chat;

use Exception;
use MatthijsThoolen\Slacky\Endpoint\Chat\Delete;
use MatthijsThoolen\Slacky\Endpoint\Chat\GetPermalink;
use MatthijsThoolen\Slacky\Endpoint\Chat\PostMessage;
use MatthijsThoolen\Slacky\Endpoint\Chat\Update;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Model\Message\Message;
use MatthijsThoolen\Slacky\Model\SlackyResponse;
use MatthijsThoolen\Slacky\Slacky;
use MatthijsThoolen\Slacky\SlackyFactory;
use PHPUnit\Framework\TestCase;
use function getenv;

/**
 * Test all Chat endpoint messages
 */
class MessageTest extends TestCase
{

    /**
     * Test if a message is send successfully
     *
     * @covers \MatthijsThoolen\Slacky\Model\Message\Message
     * @covers \MatthijsThoolen\Slacky\Endpoint\Chat\PostMessage
     * @throws Exception
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
     * @throws SlackyException
     */
    public function testGetPermalink(Message $message)
    {
        /** @var GetPermalink $getPermalink */
        $getPermalink = SlackyFactory::build(GetPermalink::class);
        self::assertInstanceOf(GetPermalink::class, $getPermalink);

        $permalink = $getPermalink
            ->setMessageTs($message->getTs())
            ->setChannel($message->getChannel())
            ->send();

        self::assertTrue($permalink->isOk());

        $body = $permalink->getBody();
        self::assertNotFalse(
            filter_var(
                $body['permalink'],
                FILTER_VALIDATE_URL
            ),
            'Permalink is not a valid URL'
        );

        return $message;
    }

    /**
     * @covers  \MatthijsThoolen\Slacky\Endpoint\Chat\Update
     * @covers  \MatthijsThoolen\Slacky\Model\Message\Message::update
     * @depends testGetPermalink
     * @param Message $message
     * @return Message
     * @throws SlackyException
     */
    public function testUpdateMessage(Message $message)
    {
        /** @var Update $updateMessage */
        $updateMessage = SlackyFactory::build(Update::class);
        self::assertInstanceOf(Update::class, $updateMessage);

        $message->setText('Updated message texts for unit test');

        // Test with direct update
        $response = $updateMessage->setMessage($message)->send();
        self::assertTrue($response->isOk());

        // Test with update via model
        self::assertTrue($message->setText('Second update')->update());

        return $message;
    }

    /**
     * - First remove the message with the delete option available in the message class
     * - Then check if the message is really removed
     *
     * @covers  \MatthijsThoolen\Slacky\Endpoint\Chat\Delete
     * @covers  \MatthijsThoolen\Slacky\Model\Message\Message::delete
     * @depends testUpdateMessage
     * @param Message $message
     * @throws SlackyException
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
