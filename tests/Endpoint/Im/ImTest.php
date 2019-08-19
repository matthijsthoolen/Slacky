<?php

namespace MatthijsThoolen\Slacky\Tests\Endpoint\Chat;

use MatthijsThoolen\Slacky\Endpoint\Im\History;
use MatthijsThoolen\Slacky\Endpoint\Im\ListAll;
use MatthijsThoolen\Slacky\Endpoint\Im\Mark;
use MatthijsThoolen\Slacky\Endpoint\Im\Open;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Model\Im;
use MatthijsThoolen\Slacky\Model\Message\Message;
use MatthijsThoolen\Slacky\Model\SlackyResponse;
use MatthijsThoolen\Slacky\Model\User;
use MatthijsThoolen\Slacky\SlackyFactory;
use MatthijsThoolen\Slacky\Tests\Helpers\MessageHelper;
use PHPUnit\Framework\TestCase;
use function getenv;

class ImTest extends TestCase
{

    /**
     * @covers \MatthijsThoolen\Slacky\Endpoint\Im\Open
     * @covers \MatthijsThoolen\Slacky\Model\Im::isOpen
     * @covers \MatthijsThoolen\Slacky\Endpoint\Conversations\Info::send
     * @throws SlackyException
     */
    public function testOpenIm()
    {
        $user = new User();
        $user->setId(getenv('SLACK_PHPUNIT_USER'));

        /** @var Open $openIm */
        $openIm = SlackyFactory::make(Open::class);
        self::assertInstanceOf(Open::class, $openIm);

        $response = $openIm->setUser($user)->send();
        $im       = $response->getObject();
        self::assertInstanceOf(Im::class, $im);

        $im->refreshInfo();
        self::assertTrue($im->isOpen());

        return $im;
    }

    /**
     * 1) Create a new IM object
     * 2) Try to set the empty IM object to openEndpoint. Expect a exception.
     * 3) Set User to IM object, and try again
     *
     * @throws SlackyException
     *
     * @covers \MatthijsThoolen\Slacky\Endpoint\Im\Open::setIm()
     * @covers \MatthijsThoolen\Slacky\Endpoint\Im\Open::setUser()
     */
    public function testOpenExistingIm()
    {
        $im     = new Im();
        $openIm = SlackyFactory::make(Open::class);

        try {
            $openIm->setIm($im);
        } catch (SlackyException $e) {
            static::assertStringContainsString('Im user is not set', $e->getMessage());
        }

        $im->setUser((new User())->setId(getenv('SLACK_PHPUNIT_USER')));

        static::assertInstanceOf(Open::class, $openIm->setIm($im));
    }

    /**
     * 1) Send 2 messages into the channel
     * 2) Get the history, only ask for one message at a time
     * 3) Check if all messages are a Message instance
     * 4) Make sure the MessageIterable::next() function is called at least once
     *
     * @param Im $im
     *
     * @return Im
     *
     * @throws SlackyException
     *
     * @depends testOpenIm
     * @covers  \MatthijsThoolen\Slacky\Endpoint\Im\History
     * @covers  \MatthijsThoolen\Slacky\Model\Message\MessageIterable
     */
    public function testHistory(Im $im)
    {
        /** @var History $historyFactory */
        $historyFactory = SlackyFactory::make(History::class);
        $messages       = $historyFactory->setIm($im)->setCount(1)->send();

        MessageHelper::sendMessage($im->getId(), 'Friends are at');
        MessageHelper::sendMessage($im->getId(), 'Central Perk');

        $count = 0;
        foreach ($messages as $message) {
            $count++;
            self::assertInstanceOf(Message::class, $message);
            if ($count === 2) {
                break;
            }
        }

        self::assertSame(2, $count);

        return $im;
    }

    /**
     * 1) Send 2 messages
     * 2) Mark read at timestamp of first message
     * 3) Check if first message is indeed marked
     *
     * @param Im $im
     *
     * @throws SlackyException
     *
     * @depends testHistory
     *
     * @covers  \MatthijsThoolen\Slacky\Endpoint\Im\Mark
     * @covers  \MatthijsThoolen\Slacky\Model\Im::getLastRead
     * @covers  \MatthijsThoolen\Slacky\Model\Im::refreshInfo
     */
    public function testMark(Im $im)
    {
        /** @var Mark $mark */
        $mark = SlackyFactory::make(Mark::class);
        static::assertInstanceOf(Mark::class, $mark);

        $message1 = MessageHelper::sendMessage($im->getId(), 'Mark me!');
        MessageHelper::sendMessage($im->getId(), 'NEVER READ ME!');

        self::assertInstanceOf(
            SlackyResponse::class, $mark->setChannel($im)->setTs($message1->getTs())->send()
        );

        $im->refreshInfo();

        static::assertEquals($message1->getTs(), $im->getLastRead());
    }

    /**
     * Close a open IM and check if the state is now closed
     *
     * @param Im $im
     *
     * @throws SlackyException
     *
     * @depends testHistory
     * @covers  \MatthijsThoolen\Slacky\Endpoint\Im\Close
     * @covers  \MatthijsThoolen\Slacky\Model\Im::isOpen
     * @covers  \MatthijsThoolen\Slacky\Model\Im::refreshInfo
     */
    public function testCloseIm(Im $im)
    {
        self::assertTrue($im->isOpen());

        $im->close();
        $im->refreshInfo();

        self::assertFalse($im->isOpen());
    }

    /**
     * @throws SlackyException
     *
     * @covers MatthijsThoolen\Slacky\Endpoint\Im\ListAll::send
     */
    public function testListAll()
    {
        /** @var ListAll $listAll */
        $listAll = SlackyFactory::make(ListAll::class);
        static::assertInstanceOf(ListAll::class, $listAll);

        $response = $listAll->send();
        static::assertTrue($response->isOk());

        static::assertContainsOnlyInstancesOf(Im::class, $response->getObject());
    }

    /**
     * @throws SlackyException
     */
    public static function tearDownAfterClass(): void
    {
        MessageHelper::cleanUp();
    }
}
