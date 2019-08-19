<?php

namespace MatthijsThoolen\Slacky\Tests\Helpers;

use MatthijsThoolen\Slacky\Endpoint\Conversations\Archive;
use MatthijsThoolen\Slacky\Endpoint\Conversations\Create;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Model\Channel;
use MatthijsThoolen\Slacky\Slacky;
use MatthijsThoolen\Slacky\SlackyFactory;
use function strtolower;
use function uniqid;

class ChannelHelper
{
    /** @var Channel[] */
    private static $channels = [];

    /**
     * Create a new channel, will be archived when cleanUp is called
     *
     * @param string $name
     *
     * @return Channel
     * @throws SlackyException
     */
    public static function createChannel($name = null)
    {
        if ($name === null) {
            $name = strtolower(uniqid('UT'));
        }

        $createEndpoint = SlackyFactory::make(Create::class);

        $response = $createEndpoint->setName($name)->send();

        /** @var Channel $channel */
        $channel = $response->getObject();

        self::$channels[] = $channel;

        return $channel;
    }

    /**
     * Cleanup all created channels
     */
    public static function cleanUp()
    {
        $archive = SlackyFactory::make(Archive::class);

        foreach (self::$channels as $channel) {
            try {
                $archive->setChannel($channel)->send();
            } catch (SlackyException $e) {
                continue;
            }
        }
    }
}
