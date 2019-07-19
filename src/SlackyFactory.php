<?php

namespace MatthijsThoolen\Slacky;

use Exception;
use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Exception\SlackyException;
use MatthijsThoolen\Slacky\Model\Model;

class SlackyFactory
{

    /** @var bool */
    private static $initialized = false;

    /** @var Slacky */
    private static $slacky;

    /**
     * @throws SlackyException
     */
    public static function initialize()
    {
        if (self::$initialized === true) {
            return;
        }

        $slackToken = getenv('SLACK_BOT_TOKEN');

        if ($slackToken === false) {
            throw new SlackyException('SLACK_TOKEN is not set in the environmental variables.');
        }

        self::$slacky = new Slacky($slackToken);

        self::$initialized = true;
    }

    /**
     * @param string $endpointNamespace
     * @return Endpoint|Model
     * @throws SlackyException
     */
    public static function build($endpointNamespace)
    {
        self::initialize();
        if ($endpointNamespace === '') {
            throw new SlackyException('Invalid endpoint');
        }

        if (class_exists($endpointNamespace) === true) {
            $endpoint = new $endpointNamespace(self::$slacky);
            return $endpoint;
        } else {
            throw new SlackyException($endpointNamespace . ' does not exist!');
        }
    }

    /**
     * @param $name
     * @return Endpoint
     * @throws SlackyException
     */
    public static function buildEndpoint($name)
    {
        return self::build($name);
    }

    /**
     * @param $name
     * @return Model
     * @throws SlackyException
     */
    public static function buildModel($name)
    {
        return self::build($name);
    }

}
