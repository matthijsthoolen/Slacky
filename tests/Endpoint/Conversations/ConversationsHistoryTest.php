<?php

namespace MatthijsThoolen\Slacky\Tests\Endpoint\Conversations;

use MatthijsThoolen\Slacky\Endpoint\Conversations\History;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Model\SlackyResponse;
use MatthijsThoolen\Slacky\SlackyFactory;
use MatthijsThoolen\Slacky\Tests\Helpers\ChannelHelper;
use MatthijsThoolen\Slacky\Tests\Helpers\MessageHelper;
use PHPUnit\Framework\TestCase;
use function uniqid;

class ConversationsHistoryTest extends TestCase
{

    /**
     * @throws SlackyException
     */
    public function testChannelHistory()
    {
        $historyEndpoint = SlackyFactory::make(History::class);

        $channel = ChannelHelper::createChannel();

        $messageOne   = MessageHelper::sendMessage($channel, uniqid());
        $messageTwo   = MessageHelper::sendMessage($channel, uniqid());
        $messageThree = MessageHelper::sendMessage($channel, uniqid());

        $historyEndpoint->setLimit(1);

        $responses = [];

        $responses[] = $historyEndpoint->setChannel($channel)->send();

        while ($historyEndpoint->hasNextPage()) {
            $nextPage = $historyEndpoint->nextPage();
            static::assertInstanceOf(SlackyResponse::class, $nextPage);
            $responses[] = $nextPage;
        }

        $messageIds = [];
        foreach ($responses as $response) {
            $message      = $response->getMessages()[0];
            $messageIds[] = $message['ts'];
        }

        // All send messages should be returned. There might be more messages returned (joined etc.)
        static::assertTrue(!array_diff(
            [$messageOne->getTs(), $messageTwo->getTs(), $messageThree->getTs()],
            $messageIds
        ));
    }

    /**
     * @throws SlackyException
     */
    public static function tearDownAfterClass(): void
    {
        MessageHelper::cleanUp();
        ChannelHelper::cleanUp();
    }
}
