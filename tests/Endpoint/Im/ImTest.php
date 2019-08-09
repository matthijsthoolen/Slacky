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

        return $im;
    }

    /**
     * Close a open IM and check if the state is now closed and archived
     *
     * @depends testOpenIm
     * @param Im $im
     * @throws SlackyException
     */
    public function testCloseIm(Im $im)
    {
        self::assertTrue($im->isOpen());

        $im->close();

        self::assertFalse($im->isOpen());
        self::assertTrue($im->isArchived());
    }
}
