<?php

namespace MatthijsThoolen\Slacky;

use GuzzleHttp\Client;

class ClientFactory
{
    public static function create(string $token): Client
    {
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/x-www-form-urlencoded'
        ];

        $client = new Client([
            'base_uri' => 'https://slack.com/api/',
            'headers'  => $headers
         ]);

        return $client;
    }
}
