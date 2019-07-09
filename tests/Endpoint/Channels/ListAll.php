<?php

namespace MatthijsThoolen\Slacky\Tests\Endpoint\Channels;

use GuzzleHttp\Exception\GuzzleException;
use MatthijsThoolen\Slacky\Endpoint\Channels\ListAll;
use MatthijsThoolen\Slacky\Model\Channel;
use MatthijsThoolen\Slacky\Model\SlackyResponse;
use MatthijsThoolen\Slacky\Slacky;
use MatthijsThoolen\Slacky\SlackyFactory;
use PHPUnit\Framework\TestCase;

class ListAllTest extends TestCase
{
    /**
     * @throws \Exception
     * @throws GuzzleException
     */
    public function testListAll()
    {
        $slackToken = getenv('SLACK_BOT_TOKEN');
        new Slacky($slackToken);

        $listAllChannel = SlackyFactory::build(ListAll::class);
        self::assertInstanceOf(ListAll::class, $listAllChannel);

        $response = $listAllChannel->send();
        self::assertInstanceOf(SlackyResponse::class, $response);

        self::assertContainsOnlyInstancesOf(Channel::class, $response->getObject());
    }
}
