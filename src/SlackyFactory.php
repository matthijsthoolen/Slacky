<?php

namespace MatthijsThoolen\Slacky;

use Exception;
use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\Model;

class SlackyFactory
{

    /** @var bool */
    private static $initialized = false;

    /** @var Slacky */
    private static $slacky;

    /**
     * @throws Exception
     */
    public static function initialize()
    {
        if (self::$initialized === true) {
            return;
        }

        $slackToken = getenv('SLACK_BOT_TOKEN');

        if ($slackToken === false) {
            throw new Exception('SLACK_TOKEN is not set in the environmental variables.');
        }

        self::$slacky = new Slacky($slackToken);

        self::$initialized = true;
    }

    /**
     * @param string $name
     * @param string $type
     * @return Endpoint|Model
     * @throws Exception
     */
    public static function build($name = '', $type = 'endpoint')
    {
        self::initialize();
        if ($name === '') {
            throw new Exception('Invalid endpoint');
        }

        $type = ucfirst($type);

        if (in_array($type, ['Endpoint', 'Model'], true) === false) {
            throw new Exception('Invalid type');
        }

        $currentNamespace = __NAMESPACE__;
        $className = str_replace('.', '\\', $name);

        // Small hack if we need a List endpoint because List is a reserved keyword.
        $className .= substr($className, -4) === 'List' ? 'All' : '';

        $endpointNamespace = $currentNamespace . '\\' . $type . '\\' .  $className;

        if (class_exists($endpointNamespace) === true) {
            $endpoint = new $endpointNamespace(self::$slacky);
            return $endpoint;
        } else {
            throw new Exception($type . ' does not exist!');
        }
    }

    /**
     * @param $name
     * @return Endpoint
     * @throws Exception
     */
    public static function buildEndpoint($name)
    {
        return self::build($name, 'Endpoint');
    }

    /**
     * @param $name
     * @return Model
     * @throws Exception
     */
    public static function buildModel($name)
    {
        return self::build($name, 'Model');
    }

}