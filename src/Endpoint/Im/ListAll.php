<?php

namespace MatthijsThoolen\Slacky\Endpoint\Im;

use Exception;
use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\Im;
use MatthijsThoolen\Slacky\Model\SlackyResponse;

/**
 * @documentation https://api.slack.com/methods/im.listroo
 */
class ListAll extends Endpoint
{
    /** @var string */
    public $method = 'GET';

    /** @var string */
    public $uri = 'im.list';

    /**
     * @param SlackyResponse $response
     * @return SlackyResponse
     * @throws Exception
     */
    public function handleResponse(SlackyResponse $response)
    {
        //TODO: Switch to cursor based pagination
        parent::handleResponse($response);

        $ims = array();

        /** @noinspection PhpUndefinedMethodInspection */
        $bodyIms = $response->getIms();

        if ($bodyIms === null) {
            return $response;
        }

        foreach ($bodyIms as $im) {
            $ims[] = (new Im())->loadData($im);
        }

        $response->setObject($ims);

        return $response;
    }
}
