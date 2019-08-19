<?php

namespace MatthijsThoolen\Slacky\Tests\Endpoint\Conversations;

use MatthijsThoolen\Slacky\Endpoint\Conversations\Archive;
use MatthijsThoolen\Slacky\Endpoint\Conversations\Close;
use MatthijsThoolen\Slacky\Endpoint\Conversations\Create;
use MatthijsThoolen\Slacky\Endpoint\Conversations\Info;
use MatthijsThoolen\Slacky\Endpoint\Conversations\Invite;
use MatthijsThoolen\Slacky\Endpoint\Conversations\Join;
use MatthijsThoolen\Slacky\Endpoint\Conversations\Kick;
use MatthijsThoolen\Slacky\Endpoint\Conversations\Leave;
use MatthijsThoolen\Slacky\Endpoint\Conversations\Members;
use MatthijsThoolen\Slacky\Endpoint\Conversations\Open;
use MatthijsThoolen\Slacky\Endpoint\Conversations\Rename;
use MatthijsThoolen\Slacky\Endpoint\Conversations\SetPurpose;
use MatthijsThoolen\Slacky\Endpoint\Conversations\SetTopic;
use MatthijsThoolen\Slacky\Endpoint\Conversations\Unarchive;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Model\Conversation;
use MatthijsThoolen\Slacky\Model\Im;
use MatthijsThoolen\Slacky\Model\Channel;
use MatthijsThoolen\Slacky\Model\PrivateChannel;
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
     * @covers \MatthijsThoolen\Slacky\Model\Channel
     * @covers \MatthijsThoolen\Slacky\Model\User::setId
     */
    public function testCreate()
    {
        $create = SlackyFactory::make(Create::class);

        $response = $create
            ->setName(strtolower(uniqid('UT')))
            ->setIsPrivate(false)
            ->setUsers([(new User())->setId(getenv('SLACK_PHPUNIT_USER'))])
            ->send();

        /** @var Channel $channel */
        $channel = $response->getObject();
        static::assertInstanceOf(Channel::class, $channel);

        $channel->refreshInfo();
        static::assertEquals(1, $channel->getNumMembers());
        static::assertEquals($create->getName(), $channel->getName());
        static::assertFalse($create->isPrivate());

        $userIds = [];
        foreach ($channel->getMembers() as $member) {
            $userIds[] = $member->getId();
        }
        static::assertEquals($create->getUserIds(), $userIds);

        return $channel;
    }

    /**
     * 1) Create a private channel
     * 2) archive the private channel
     *
     * @throws SlackyException
     */
    public function testCreatePrivate()
    {
        $create = SlackyFactory::make(Create::class);

        $response = $create
            ->setName(strtolower(uniqid('UT-private')))
            ->setIsPrivate(true)
            ->setUsers([(new User())->setId(getenv('SLACK_PHPUNIT_USER'))])
            ->send();

        /** @var PrivateChannel $channel */
        $channel = $response->getObject();
        static::assertInstanceOf(PrivateChannel::class, $channel);

        $archive = SlackyFactory::make(Archive::class);
        static::assertTrue($archive->setChannel($channel)->send());
    }

    /**
     * 1) Get the current name
     * 2) Add -rename to the end of the current name, and save
     * 3) Check if the name new is correctly set after a refreshInfo call
     * 4) Check if the previousName is set in ge tPreviousNames
     *
     * @param Channel $channel
     *
     * @return Channel
     * @throws SlackyException
     *
     * @depends testCreate
     */
    public function testRename(Channel $channel)
    {
        $renameEndpoint = SlackyFactory::make(Rename::class);

        $oldName = $channel->getName();
        $newName = $oldName . '-renamed';
        $renameEndpoint->setChannel($channel)->setName($newName)->send();

        self::assertSame($channel, $renameEndpoint->getChannel());
        self::assertEquals($newName, $renameEndpoint->getName());

        self::assertEquals($newName, $channel->refreshInfo()->getName());
        self::assertContains($oldName, $channel->getPreviousNames());

        return $channel;
    }

    /**
     * 1) Set the purpose and topic with the endpoint helpers.
     * 2) Reload the channel information
     * 3) Test if the channel has the correct topic and purpose
     *
     * @param Channel $channel
     *
     * @return Channel
     *
     * @throws SlackyException
     *
     * @depends testRename
     * @covers  \MatthijsThoolen\Slacky\Endpoint\Conversations\SetPurpose
     * @covers  \MatthijsThoolen\Slacky\Endpoint\Conversations\SetTopic
     */
    public function testPurposeAndTopic(Channel $channel)
    {
        $purposeEndpoint = SlackyFactory::make(SetPurpose::class);
        $topicEndpoint   = SlackyFactory::make(SetTopic::class);

        $purposeEndpoint
            ->setChannel($channel)
            ->setPurposeString('Purpose are for unit tests')
            ->send();
        $topicEndpoint->setChannel($channel)->setTopicString('Unit Test')->send();

        static::assertEquals('Purpose are for unit tests', $purposeEndpoint->getPurpose());
        static::assertSame($channel, $purposeEndpoint->getChannel());
        static::assertEquals('Unit Test', $topicEndpoint->getTopic());
        static::assertSame($channel, $topicEndpoint->getChannel());

        $channel->refreshInfo();

        $purpose = $channel->getPurpose();
        $topic   = $channel->getTopic();
        self::assertEquals('Purpose are for unit tests', $purpose['value']);
        self::assertEquals('Unit Test', $topic['value']);

        return $channel;
    }

    /**
     * 1) Invite a new user to a channel created in TestCreate
     *
     * @param Channel $channel
     *
     * @depends testPurposeAndTopic
     * @return Channel
     * @throws SlackyException
     */
    public function testInvite(Channel $channel)
    {
        $invite = SlackyFactory::make(Invite::class);

        $users    = [(new User())->setId(getenv('SLACK_PHPUNIT_USER_FRIEND'))];
        $response = $invite
            ->setChannel($channel)
            ->setUsers($users)
            ->send();

        static::assertTrue($response->isOk());
        static::assertSame($invite->getChannel(), $channel);
        static::assertEquals($invite->getUsers(), $users);

        return $channel;
    }

    /**
     * 1) The channel this function received should contain 2 members
     * 2) Check if the members endpoint returns a cursor after the first call
     * 3) Check the content of the first call
     * 4) Send a request for the nextPage
     * 5) Check if next page is filled, and no more pages are following.
     *
     * @param Channel $channel
     *
     * @return Channel
     * @throws SlackyException
     *
     * @depends testInvite
     * @covers  \MatthijsThoolen\Slacky\Endpoint\Conversations\Members
     * @covers  \MatthijsThoolen\Slacky\Helpers\Traits\Cursor
     */
    public function testMembers(Channel $channel)
    {
        self::assertEquals(2, $channel->refreshInfo()->getNumMembers());

        $membersEndpoint = SlackyFactory::make(Members::class);
        $response        = $membersEndpoint->setChannel($channel)->setLimit(1)->send();

        self::assertNotNull($response->getNextCursor());
        self::assertSame($channel, $membersEndpoint->getChannel());

        $page2 = $membersEndpoint->nextPage();

        self::assertContainsOnlyInstancesOf(User::class, $page2->getObject());
        self::assertEmpty($page2->getNextCursor());

        self::assertNull($membersEndpoint->nextPage());
        self::assertEquals(1, $membersEndpoint->getLimit());

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
     * @param Channel $channel
     *
     * @return Channel
     *
     * @throws SlackyException
     *
     * @depends testMembers
     * @covers  \MatthijsThoolen\Slacky\Endpoint\Conversations\Leave
     * @covers  \MatthijsThoolen\Slacky\Endpoint\Conversations\Join
     * @covers  \MatthijsThoolen\Slacky\Model\Channel::getNumMembers
     */
    public function testLeaveAndJoin(Channel $channel)
    {
        $numMembers = $channel->refreshInfo()->getNumMembers();

        $leave    = SlackyFactory::make(Leave::class);
        $response = $leave->setChannel($channel)->send();
        self::assertTrue($response->isOk());

        self::assertEquals($numMembers - 1, $channel->refreshInfo()->getNumMembers());
        self::assertSame($channel, $leave->getChannel());

        $join     = SlackyFactory::make(Join::class);
        $response = $join->setChannel($channel)->send();
        self::assertTrue($response->isOk());

        self::assertEquals($numMembers, $channel->refreshInfo()->getNumMembers());
        self::assertSame($channel, $join->getChannel());

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
     * @param Channel $channel
     *
     * @return Channel
     * @throws SlackyException
     *
     * @depends testCreate
     * @covers  \MatthijsThoolen\Slacky\Endpoint\Conversations\Kick
     * @covers  \MatthijsThoolen\Slacky\Model\SlackyResponse::getError
     */
    public function testKick(Channel $channel)
    {
        $kick = SlackyFactory::make(Kick::class);

        try {
            $kick
                ->setChannel($channel)
                ->setUser((new User())->setId(getenv('SLACK_PHPUNIT_USER')))
                ->send();
        } catch (SlackyException $e) {
            self::assertStringContainsString('cant_kick_self', $e->getMessage());
        }

        $numMembers = $channel->refreshInfo()->getNumMembers();

        $user     = (new User())->setId(getenv('SLACK_PHPUNIT_USER_FRIEND'));
        $response = $kick
            ->setChannel($channel)
            ->setUser($user)
            ->send();

        self::assertTrue($response->isOk());
        self::assertEquals($numMembers - 1, $channel->refreshInfo()->getNumMembers());
        self::assertSame($channel, $kick->getChannel());
        self::assertSame($user, $kick->getUser());

        return $channel;
    }

    /**
     * 1) Test Info factory
     * 2) Test if information is updated correctly
     *
     * @param Channel $channel
     *
     * @return Channel
     * @throws SlackyException
     *
     * @depends testKick
     */
    public function testInfo(Channel $channel)
    {
        $infoEndpoint = SlackyFactory::make(Info::class);
        static::assertInstanceOf(Info::class, $infoEndpoint);

        $response = $infoEndpoint
            ->setIncludeLocale(false)
            ->setIncludeNumMembers(true)
            ->setConversation($channel)
            ->send();

        static::assertTrue($response->isOk());
        static::assertInstanceOf(Channel::class, $response->getObject());
        static::assertSame($channel, $response->getObject());

        return $channel;
    }

    /**
     * 1) Make sure the channel is currently not archived before the test starts
     * 3) Try to unarchive the chat, check if this gives the expected error
     * 2) Archive the chat, refreshinfo and check
     *
     * @param Channel $channel
     *
     * @throws SlackyException
     *
     * @depends testInfo
     * @covers  \MatthijsThoolen\Slacky\Endpoint\Conversations\Archive
     * @covers  \MatthijsThoolen\Slacky\Endpoint\Conversations\Unarchive
     */
    public function testArchive(Channel $channel)
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
        self::assertSame($channel, $unarchive->getChannel());

        $archive->setChannel($channel)->send();
        self::assertTrue($channel->refreshInfo()->isArchived());
        self::assertSame($channel, $archive->getChannel());
    }

    /**
     * 1) Create a IM channel
     * 2) Check if it's open
     * 3) Open the channel, and check if it's correctly opened
     * 4) Close channel
     *
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
        self::assertSame($im, $open->getChannel());

        $close->setChannel($im)->send();
        self::assertFalse($im->refreshInfo()->isOpen());
        self::assertSame($im, $close->getChannel());
    }
}
