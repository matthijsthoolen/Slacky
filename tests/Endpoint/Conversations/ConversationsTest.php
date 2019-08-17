<?php

namespace MatthijsThoolen\Slacky\Tests\Endpoint\Conversations;

use MatthijsThoolen\Slacky\Endpoint\Conversations\Archive;
use MatthijsThoolen\Slacky\Endpoint\Conversations\Close;
use MatthijsThoolen\Slacky\Endpoint\Conversations\Create;
use MatthijsThoolen\Slacky\Endpoint\Conversations\Open;
use MatthijsThoolen\Slacky\Endpoint\Conversations\Unarchive;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Model\Channel;
use MatthijsThoolen\Slacky\Model\Im;
use MatthijsThoolen\Slacky\Model\PublicChannel;
use MatthijsThoolen\Slacky\Model\User;
use MatthijsThoolen\Slacky\SlackyFactory;
use PHPUnit\Framework\TestCase;
use function getenv;
use function strtolower;
use function uniqid;

class ConversationsTest extends TestCase
{
    /**
     *
     * @throws SlackyException
     *
     * @covers \MatthijsThoolen\Slacky\Endpoint\Conversations\Create
     * @covers \MatthijsThoolen\Slacky\Model\PublicChannel
     * @covers \MatthijsThoolen\Slacky\Model\User::setId
     */
    public function testCreate()
    {
        $create = SlackyFactory::make(Create::class);

        $name     = strtolower(uniqid('UT'));
        $response = $create
            ->setName($name)
            ->setIsPrivate(false)
            ->setUsers([(new User())->setId(getenv('SLACK_PHPUNIT_USER'))])
            ->send();

        /** @var PublicChannel $channel */
        $channel = $response->getObject();
        static::assertInstanceOf(PublicChannel::class, $channel);

        $channel->refreshInfo();
        static::assertEquals(1, $channel->getNumMembers());
        static::assertEquals($name, $channel->getName());

        return $channel;
    }

    /**
     * 1) Make sure the channel is currently not archived before the test starts
     * 2) Archive the chat, refreshinfo and check
     * 3) Unarchive the chat, refreshinfo and check
     *
     * @param PublicChannel $channel
     *
     * @throws SlackyException
     *
     * @depends testCreate
     * @covers  \MatthijsThoolen\Slacky\Endpoint\Conversations\Archive
     * @covers  \MatthijsThoolen\Slacky\Endpoint\Conversations\Unarchive
     */
    public function testArchive($channel)
    {
        $archive = SlackyFactory::make(Archive::class);
        static::assertInstanceOf(Archive::class, $archive);

        $unarchive = SlackyFactory::make(Unarchive::class);
        static::assertInstanceOf(Unarchive::class, $unarchive);

        if ($channel->isArchived()) {
            $unarchive->setChannel($channel)->send();
        }

        self::assertFalse($channel->isArchived());

        $archive->setChannel($channel)->send();
        $channel->refreshInfo();

        self::assertTrue($channel->isArchived());

        $unarchive->setChannel($channel)->send();
        $channel->refreshInfo();
        self::assertFalse($channel->isArchived());
    }

    /**
     * @throws SlackyException
     *
     * @covers \MatthijsThoolen\Slacky\Endpoint\Conversations\Close
     * @covers \MatthijsThoolen\Slacky\Endpoint\Conversations\Open
     * @covers \MatthijsThoolen\Slacky\Model\Im::isOpen
     */
    public function testOpenClose()
    {
        $open  = SlackyFactory::make(Open::class);
        $close = SlackyFactory::make(Close::class);

        $im = (new Im())->setId(getenv('SLACK_PHPUNIT_IM'))->refreshInfo();
        if ($im->isOpen()) {
            $close->setChannel($im)->send();
            $im->refreshInfo();
        }

        $open->setChannel($im)->send();
        self::assertTrue($im->refreshInfo()->isOpen());

        $close->setChannel($im)->send();
        self::assertFalse($im->refreshInfo()->isOpen());
    }
}
