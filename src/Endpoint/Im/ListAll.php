<?php

namespace MatthijsThoolen\Slacky\Endpoint\Im;

use GuzzleHttp\Psr7\Response;
use MatthijsThoolen\Slacky\Endpoint\Endpoint;
use MatthijsThoolen\Slacky\Model\Im;

class ListAll extends Endpoint
{
    /** @var string */
    public $method = 'GET';

    /** @var string */
    public $uri = 'im.list';

    /**
     * @param Response $response
     * @return Im[]
     */
    public function request(Response $response)
    {
        //TODO: Switch to cursor based pagination
        $body = parent::handleResponse($response);

        $ims = array();

        if ($body['ok'] === true) {
            foreach($body['ims'] as $im) {
                $ims[] = (new Im())->loadData($im);
            }
        }

        return $ims;
    }
}