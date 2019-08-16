<?php

namespace MatthijsThoolen\Slacky\Tests\Endpoint\Conversations;

use MatthijsThoolen\Slacky\Endpoint\Conversations\Archive;
use MatthijsThoolen\Slacky\Endpoint\Conversations\Close;
use MatthijsThoolen\Slacky\Endpoint\Conversations\Open;
use MatthijsThoolen\Slacky\Endpoint\Conversations\Unarchive;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Model\Im;
use MatthijsThoolen\Slacky\SlackyFactory;
use PHPUnit\Framework\TestCase;

class ConversationsTest extends TestCase
{
    /**
     * 1) Make sure the channel is currently not archived before the test starts
     * 2) Archive the chat, refreshinfo and check
     * 3) Unarchive the chat, refreshinfo and check
     *
     * @throws SlackyException
     * @covers \MatthijsThoolen\Slacky\Endpoint\Conversations\Archive
     * @covers \MatthijsThoolen\Slacky\Endpoint\Conversations\Unarchive
     * @covers \MatthijsThoolen\Slacky\Model\Im::setId
     */
    public function testArchive()
    {
        /** @var Archive $archive */
        $archive = SlackyFactory::build(Archive::class);
        static::assertInstanceOf(Archive::class, $archive);

        /** @var Unarchive $unarchive */
        $unarchive = SlackyFactory::build(Unarchive::class);
        static::assertInstanceOf(Unarchive::class, $unarchive);

        $im = (new Im())->setId(getenv('SLACK_PHPUNIT_CHANNEL'))->refreshInfo();

        if ($im->isArchived()) {
            $unarchive->setChannel($im)->send();
        }

        self::assertFalse($im->isArchived());

        $archive->setChannel($im)->send();
        $im->refreshInfo();

        self::assertTrue($im->isArchived());

        $unarchive->setChannel($im)->send();
        $im->refreshInfo();
        self::assertFalse($im->isArchived());
    }

    /**
     * @throws SlackyException
     *
     * @covers \MatthijsThoolen\Slacky\Endpoint\Conversations\Close
     * @covers \MatthijsThoolen\Slacky\Endpoint\Conversations\Open
     * @covers \MatthijsThoolen\Slacky\Model\Im::isOpen
     * @covers \MatthijsThoolen\Slacky\Model\Im::isClose
     */
    public function testOpenClose()
    {
        /** @var Open $open */
        $open = SlackyFactory::build(Open::class);
        /** @var Close $close */
        $close = SlackyFactory::build(Close::class);

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
