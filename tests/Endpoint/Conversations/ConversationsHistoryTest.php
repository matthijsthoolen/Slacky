<?php

namespace MatthijsThoolen\Slacky\Tests\Endpoint\Conversations;

use MatthijsThoolen\Slacky\Endpoint\Conversations\History;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Model\Channel;
use MatthijsThoolen\Slacky\Model\Message\Message;
use MatthijsThoolen\Slacky\Model\SlackyResponse;
use MatthijsThoolen\Slacky\SlackyFactory;
use MatthijsThoolen\Slacky\Tests\Helpers\ChannelHelper;
use MatthijsThoolen\Slacky\Tests\Helpers\MessageHelper;
use PHPUnit\Framework\TestCase;
use function uniqid;

class ConversationsHistoryTest extends TestCase
{

    /** @var string[] */
    private static $messageIds;

    /** @var Message[] */
    private static $messages;

    /** @var Channel */
    private static $channel;

    /**
     * @throws SlackyException
     */
    public static function setupBeforeClass(): void
    {
        self::$channel = ChannelHelper::createChannel();

        // Create three messages
        for ($i = 0; $i <= 2; $i++) {
            $message            = MessageHelper::sendMessage(self::$channel, uniqid());
            self::$messageIds[] = $message->getTs();
            self::$messages[]   = $message;
        }
    }

    /**
     * 1) Set the latest to the third (of three total) messages, limit set to 2
     * 2) Expect to receive the second and first message.
     * 3) Check if latest is now set to the first send message
     * 4) If we set inclusive to true, and limit to 1, the endpoint should return the first message
     *
     * @throws SlackyException
     * @covers \MatthijsThoolen\Slacky\Endpoint\Conversations\History::getObjectFromResponse
     * @covers \MatthijsThoolen\Slacky\Endpoint\Conversations\History::setChannel
     * @covers \MatthijsThoolen\Slacky\Helpers\Traits\Pagination::setLatest
     * @covers \MatthijsThoolen\Slacky\Helpers\Traits\Pagination::getLatest
     * @covers \MatthijsThoolen\Slacky\Helpers\Traits\Pagination::setInclusive
     * @covers \MatthijsThoolen\Slacky\Helpers\Traits\Pagination::setLimit
     * @covers \MatthijsThoolen\Slacky\Helpers\Traits\Pagination::nextPage
     * @covers \MatthijsThoolen\Slacky\Helpers\Traits\Pagination::hasNextPage
     */
    public function testTimeBasedPagination()
    {
        $historyEndpoint = SlackyFactory::make(History::class);

        $response = $historyEndpoint
            ->setChannel(self::$channel)
            ->setLimit(2)
            ->setLatest(self::$messages[2]->getTs())
            ->send();

        self::assertEquals(2, $historyEndpoint->getLimit());
        self::assertEquals(self::$messages[2]->getTs(), $historyEndpoint->getLatest());

        /** @var Message[] $messages */
        $messages = $response->getObject();
        self::assertEquals(self::$messageIds[1], $messages[0]->getTs());
        self::assertEquals(self::$messageIds[0], $messages[1]->getTs());

        self::assertEquals(self::$messageIds[0], $historyEndpoint->getLatest());

        $response = $historyEndpoint->setInclusive(true)->setLimit(1)->send();

        /** @var Message[] $messages */
        $messages = $response->getObject();
        self::assertCount(1, $messages);
        self::assertContainsOnlyInstancesOf(Message::class, $messages);

        self::assertEquals(self::$messages[0]->getTs(), $messages[0]->getTs());

        $response = $historyEndpoint->nextPage();
        self::assertEquals(self::$messageIds[0], $response->getObject()[0]->getTs());
    }

    /**
     * @throws SlackyException
     *
     * @covers \MatthijsThoolen\Slacky\Endpoint\Conversations\History::getChannel
     * @covers \MatthijsThoolen\Slacky\Helpers\Traits\Pagination::hasNextPage
     * @covers \MatthijsThoolen\Slacky\Helpers\Traits\Pagination::nextPage
     * @covers \MatthijsThoolen\Slacky\Helpers\Traits\Pagination::setCursor
     * @covers \MatthijsThoolen\Slacky\Helpers\Traits\Pagination::handleResponse
     * @covers \MatthijsThoolen\Slacky\Helpers\Traits\Pagination::handlePagination
     * @covers \MatthijsThoolen\Slacky\Helpers\Traits\PaginationByTime::getOldest
     * @covers \MatthijsThoolen\Slacky\Helpers\Traits\PaginationByTime::isInclusive
     *
     */
    public function testChannelHistoryCursor()
    {
        $historyEndpoint = SlackyFactory::make(History::class);
        $historyEndpoint->setLimit(1);

        $responses = [$historyEndpoint->setChannel(self::$channel)->send()];
        self::assertSame(self::$channel, $historyEndpoint->getChannel());

        self::assertEquals(false, $historyEndpoint->isInclusive());
        self::assertEquals(null, $historyEndpoint->getOldest());

        while ($historyEndpoint->hasNextPage()) {
            $nextPage = $historyEndpoint->nextPage();
            static::assertInstanceOf(SlackyResponse::class, $nextPage);
            $responses[] = $nextPage;
        }

        $messageIds = [];
        foreach ($responses as $response) {
            $messageIds[] = $response->getMessages()[0]['ts'];
        }

        // All send messages should be returned. There might be more messages returned (joined etc.)
        static::assertTrue(!array_diff(self::$messageIds, $messageIds));
    }

    /**
     * 1) Provide oldest parameter
     * 2) Check if messages are receivest from oldest to newest
     * @throws SlackyException
     *
     * @covers \MatthijsThoolen\Slacky\Endpoint\Conversations\History::setOldest
     * @covers \MatthijsThoolen\Slacky\Helpers\Traits\PaginationByTime::handleResponse
     * @covers \MatthijsThoolen\Slacky\Helpers\Traits\PaginationByTime::handlePagination
     */
    public function testTimeBasedPaginationPageForward()
    {
        $expectedMessages = [self::$messageIds[1], self::$messageIds[0]];

        $historyEndpoint = SlackyFactory::make(History::class);
        $response        = $historyEndpoint
            ->setChannel(self::$channel)
            ->setLimit(2)
            ->setOldest(self::$messageIds[0])
            ->setInclusive(true)
            ->send();

        $messages = $response->getObject();
        self::assertCount(2, $messages);
        self::assertEquals(
            $expectedMessages,
            [$messages[0]->getTs(), $messages[1]->getTs()]
        );
    }

    /**
     * Remove all created data
     */
    public static function tearDownAfterClass(): void
    {
        MessageHelper::cleanUp();
        ChannelHelper::cleanUp();
    }
}
