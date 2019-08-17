<?php

namespace MatthijsThoolen\Slacky\Tests\Endpoint\Chat;

use MatthijsThoolen\Slacky\Endpoint\Chat\MeMessage;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Model\SlackyResponse;
use MatthijsThoolen\Slacky\SlackyFactory;
use PHPUnit\Framework\TestCase;

/**
 * Class MeMessageTest
 * @coversDefaultClass \MatthijsThoolen\Slacky\Endpoint\Chat\MeMessage
 */
class MeMessageTest extends TestCase
{

    /**
     * @covers ::handleResponse
     * @covers ::setText
     * @covers ::setChannel
     * @throws SlackyException
     */
    public function testMeMessage()
    {
        /** @var MeMessage $meMessage */
        $meMessage = SlackyFactory::make(MeMessage::class);
        self::assertInstanceOf(MeMessage::class, $meMessage);

        $response = $meMessage
            ->setChannel(getenv('SLACK_PHPUNIT_CHANNEL'))
            ->setText('This is a meMessage. Hi me! You go me! You are doin\' great!')
            ->send();

        self::assertInstanceOf(SlackyResponse::class, $response);
        self::assertSame(200, $response->getStatusCode());
        self::assertTrue($response->isOk());
    }
}
