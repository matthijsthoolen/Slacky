<?php

namespace MatthijsThoolen\Slacky\Endpoint\Im;

use Exception;
use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\Im;
use MatthijsThoolen\Slacky\Model\SlackyResponse;

class ListAll extends Endpoint
{
    /** @var string */
    public $method = 'GET';

    /** @var string */
    public $uri = 'im.list';

    /**
     * @param SlackyResponse $response
     * @return Im[]
     * @throws Exception
     */
    public function request(SlackyResponse $response)
    {
        //TODO: Switch to cursor based pagination
        $slackyResponse = parent::handleResponse($response);

        $ims = array();

        /** @noinspection PhpUndefinedMethodInspection */
        $bodyIms = $slackyResponse->getIms();

        if ($bodyIms === null) {
            return $ims;
        }

        foreach ($bodyIms as $im) {
            $ims[] = (new Im())->loadData($im);
        }

        return $ims;
    }
}