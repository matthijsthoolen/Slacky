<?php

namespace MatthijsThoolen\Slacky\Tests\Endpoint\Chat;

use MatthijsThoolen\Slacky\Endpoint\Im\Open;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Model\Im;
use MatthijsThoolen\Slacky\Model\User;
use MatthijsThoolen\Slacky\SlackyFactory;
use PHPUnit\Framework\TestCase;

class ImTest extends TestCase
{

    /**
     * @covers \MatthijsThoolen\Slacky\Endpoint\Im\Open
     * @covers Open::setUser
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
     * Close a open IM and check if the state is now closed
     *
     * @depends testOpenIm
     * @covers \MatthijsThoolen\Slacky\Endpoint\Im\Close
     * @covers Im::close
     * @covers Im::isOpen
     * @covers Im::refreshInfo
     * @param Im $im
     * @throws SlackyException
     */
    public function testCloseIm(Im $im)
    {
        self::assertTrue($im->isOpen());

        $im->close();
        $im->refreshInfo();

        self::assertFalse($im->isOpen());
    }
}
