<?php

namespace MatthijsThoolen\Slacky\Tests\Endpoint\Chat;

use MatthijsThoolen\Slacky\Endpoint\Im\History;
use MatthijsThoolen\Slacky\Endpoint\Im\Open;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Model\Im;
use MatthijsThoolen\Slacky\Model\Message\Message;
use MatthijsThoolen\Slacky\Model\User;
use MatthijsThoolen\Slacky\SlackyFactory;
use MatthijsThoolen\Slacky\Tests\Helpers\MessageHelper;
use PHPUnit\Framework\TestCase;

class ImTest extends TestCase
{

    /**
     * @covers \MatthijsThoolen\Slacky\Endpoint\Im\Open
     * @covers Im::isOpen
     * @covers \MatthijsThoolen\Slacky\Endpoint\Conversations\Info::send
     * @throws SlackyException
     */
    public function testOpenIm()
    {
        $user = new User();
        $user->setId(getenv('SLACK_PHPUNIT_USER'));

        /** @var Open $openIm */
        $openIm = SlackyFactory::build(Open::class);
        self::assertInstanceOf(Open::class, $openIm);

        $response = $openIm->setUser($user)->send();
        $im       = $response->getObject();
        self::assertInstanceOf(Im::class, $im);

        $im->refreshInfo();
        self::assertTrue($im->isOpen());

        return $im;
    }

    /**
     * 1) Send 2 messages into the channel
     * 2) Get the history, only ask for one message at a time
     * 3) Check if all messages are a Message instance
     * 4) Make sure the MessageIterable::next() function is called at least once
     *
     * @param Im $im
     * @return Im
     *
     * @throws SlackyException
     *
     * @depends testOpenIm
     * @covers \MatthijsThoolen\Slacky\Endpoint\Im\History
     * @covers \MatthijsThoolen\Slacky\Model\Message\MessageIterable
     */
    public function testHistory(Im $im)
    {
        /** @var History $historyFactory */
        $historyFactory = SlackyFactory::build(History::class);
        $messages       = $historyFactory->setIm($im)->setCount(1)->send();

        MessageHelper::sendMessage($im->getId(), 'Friends are at');
        MessageHelper::sendMessage($im->getId(), 'Central Perk');

        $count = 0;
        foreach ($messages as $message) {
            $count++;
            self::assertInstanceOf(Message::class, $message);
            // TODO: make sure at least 2 messages are posted to the channel
            if ($count === 2) {
                break;
            }
        }

        self::assertSame(2, $count);

        return $im;
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
     * @covers  Im::isOpen
     * @covers  Im::refreshInfo
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
     */
    public static function tearDownAfterClass() :void
    {
        MessageHelper::cleanUp();
    }
}
