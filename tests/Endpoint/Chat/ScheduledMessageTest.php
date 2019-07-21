<?php

namespace MatthijsThoolen\Slacky\Tests\Endpoint\Chat;

use MatthijsThoolen\Slacky\Endpoint\Chat\DeleteScheduledMessage;
use MatthijsThoolen\Slacky\Endpoint\Chat\ScheduleMessage;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Model\Message\ScheduledMessage;
use MatthijsThoolen\Slacky\Model\SlackyResponse;
use MatthijsThoolen\Slacky\SlackyFactory;
use PHPUnit\Framework\TestCase;
use function getenv;
use function time;

/**
 * Class ScheduledMessageTest
 * @coversDefaultClass \MatthijsThoolen\Slacky\Model\Message\ScheduledMessage
 */
class ScheduledMessageTest extends TestCase
{

    /**
     * - Create a ScheduleMessage class, and check if the factory returned correct class
     * - Create a new message and schedule it for 10 minutes from now
     * - Check the response
     * - Check if scheduled message id is succesfully added to the message model
     *
     * @covers \MatthijsThoolen\Slacky\Endpoint\Chat\ScheduleMessage
     * @covers ::jsonSerialize
     * @covers ::__construct
     * @covers ::setPostAt
     * @covers ::getPostAt
     * @covers ::send
     * @return ScheduledMessage
     * @throws SlackyException
     */
    public function testScheduleMessage()
    {
        /** @var ScheduleMessage $scheduleMessage */
        $scheduleMessage = SlackyFactory::build(ScheduleMessage::class);
        self::assertInstanceOf(ScheduleMessage::class, $scheduleMessage);

        $postAtTime = time() + 600;

        $message = new ScheduledMessage();
        $message->setChannel(getenv('SLACK_PHPUNIT_CHANNEL'));
        $message->setPostAt($postAtTime);
        $message->setText('A unit test scheduled for the future!');

        self::assertSame($postAtTime, $message->getPostAt());

        $response = $scheduleMessage->setMessage($message)->send();
        self::assertInstanceOf(SlackyResponse::class, $response);
        self::assertSame(200, $response->getStatusCode());

        $body = $response->getBody();
        self::assertNotNull($body['scheduled_message_id']);
        self::assertTrue($response->isOk());
        self::assertEquals('OK', $response->getError());

        self::assertSame($body['scheduled_message_id'], $message->getScheduledMessageId());

        return $message;
    }

    /**
     * - A scheduled message is retrieved from testScheduleMessage
     * - Create the class with the factory and check if the correct class is returned
     * - Delete the message and check if scheduledMessageId is set to null
     *
     * @covers  \MatthijsThoolen\Slacky\Endpoint\Chat\DeleteScheduledMessage
     * @covers ::delete
     * @covers ::getScheduledMessageId
     * @depends testScheduleMessage
     *
     * @param ScheduledMessage $message
     * @throws SlackyException
     */
    public function testDeleteScheduledMessage(ScheduledMessage $message)
    {
        $deleteScheduledMessage = SlackyFactory::build(DeleteScheduledMessage::class);
        self::assertInstanceOf(DeleteScheduledMessage::class, $deleteScheduledMessage);

        self::assertNotNull($message->getScheduledMessageId());
        self::assertTrue($message->delete());
        self::assertNull($message->getScheduledMessageId());
    }
}
