<?php

namespace MatthijsThoolen\Slacky\Tests\Endpoint\Conversations;

use MatthijsThoolen\Slacky\Endpoint\Conversations\Archive;
use MatthijsThoolen\Slacky\Endpoint\Conversations\Close;
use MatthijsThoolen\Slacky\Endpoint\Conversations\Create;
use MatthijsThoolen\Slacky\Endpoint\Conversations\Invite;
use MatthijsThoolen\Slacky\Endpoint\Conversations\Join;
use MatthijsThoolen\Slacky\Endpoint\Conversations\Kick;
use MatthijsThoolen\Slacky\Endpoint\Conversations\Leave;
use MatthijsThoolen\Slacky\Endpoint\Conversations\Open;
use MatthijsThoolen\Slacky\Endpoint\Conversations\Unarchive;
use MatthijsThoolen\Slacky\Exception\SlackyException;
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
     * 1) Create a new PublicChannel
     * 2) Check if the number of members is correct
     * 3) Check if the name is set correct
     * 4) Return the channel to be used in the next test
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
     * 1) Invite a new user to a channel created in TestCreate
     *
     * @param PublicChannel $channel
     *
     * @depends testCreate
     * @return PublicChannel
     * @throws SlackyException
     */
    public function testInvite(PublicChannel $channel)
    {
        $invite = SlackyFactory::make(Invite::class);

        $response = $invite
            ->setChannel($channel)
            ->setUsers([(new User())->setId(getenv('SLACK_PHPUNIT_USER_FRIEND'))])
            ->send();

        static::assertTrue($response->isOk());

        return $channel;
    }

    /**
     * 1) Count the current number of members
     * 2) Leave the channel, check if response is OK
     * 3) Make sure the new count = previous - 1
     * 4) Rejoin the channel
     * 5) Check the count
     * 6) Check if a warning is returned if trying to join while already in channel
     *
     * @param PublicChannel $channel
     * @return PublicChannel
     *
     * @throws SlackyException
     *
     * @depends testInvite
     * @covers  \MatthijsThoolen\Slacky\Endpoint\Conversations\Leave
     * @covers  \MatthijsThoolen\Slacky\Endpoint\Conversations\Join
     * @covers  \MatthijsThoolen\Slacky\Model\PublicChannel::getNumMembers
     */
    public function testLeaveAndJoin(PublicChannel $channel)
    {
        $numMembers = $channel->refreshInfo()->getNumMembers();

        $leave    = SlackyFactory::make(Leave::class);
        $response = $leave->setChannel($channel)->send();
        self::assertTrue($response->isOk());

        self::assertEquals($numMembers - 1, $channel->refreshInfo()->getNumMembers());

        $join     = SlackyFactory::make(Join::class);
        $response = $join->setChannel($channel)->send();
        self::assertTrue($response->isOk());

        self::assertEquals($numMembers, $channel->refreshInfo()->getNumMembers());

        $response = $join->send();
        $body     = $response->getBody();
        self::assertEquals('already_in_channel', $body['warning']);

        return $channel;
    }

    /**
     * 1) Try to kick self
     * 2) Expect error 'cant_kick_self'
     * 3) Kick friend, expect response is ok.
     *
     * @param PublicChannel $channel
     *
     * @return PublicChannel
     * @throws SlackyException
     *
     * @depends testCreate
     * @covers  \MatthijsThoolen\Slacky\Endpoint\Conversations\Kick
     * @covers  \MatthijsThoolen\Slacky\Model\SlackyResponse::getError
     */
    public function testKick(PublicChannel $channel)
    {
        $kick = SlackyFactory::make(Kick::class);

        try {
            $response = $kick
                ->setChannel($channel)
                ->setUser((new User())->setId(getenv('SLACK_PHPUNIT_USER')))
                ->send();
        } catch (SlackyException $e) {
            self::assertStringContainsString('cant_kick_self', $e->getMessage());
        }

        $numMembers = $channel->refreshInfo()->getNumMembers();

        $response = $kick
            ->setChannel($channel)
            ->setUser((new User())->setId(getenv('SLACK_PHPUNIT_USER_FRIEND')))
            ->send();

        self::assertTrue($response->isOk());
        self::assertEquals($numMembers - 1, $channel->refreshInfo()->getNumMembers());

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
     * @depends testKick
     * @covers  \MatthijsThoolen\Slacky\Endpoint\Conversations\Archive
     * @covers  \MatthijsThoolen\Slacky\Endpoint\Conversations\Unarchive
     */
    public function testArchive(PublicChannel $channel)
    {
        $archive = SlackyFactory::make(Archive::class);
        static::assertInstanceOf(Archive::class, $archive);

        $unarchive = SlackyFactory::make(Unarchive::class);
        static::assertInstanceOf(Unarchive::class, $unarchive);

        try {
            $unarchive->setChannel($channel)->send();
        } catch (SlackyException $e) {
            self::assertStringContainsString('not_archived', $e->getMessage());
        }
        self::assertFalse($channel->refreshInfo()->isArchived());

        $archive->setChannel($channel)->send();
        self::assertTrue($channel->refreshInfo()->isArchived());
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
