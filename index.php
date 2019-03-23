<?php

use MatthijsThoolen\Slacky\Endpoint\Users\Info;
use MatthijsThoolen\Slacky\Slacky;

require __DIR__ . '/vendor/autoload.php';

$client = new \GuzzleHttp\Client(['base_uri' => 'https://slack.com/api/']);
//$response = $client->request('POST', 'https://hooks.slack.com/services/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', [
//    'json' => [
//        'text' => 'Hello Slack World!'
//    ]
//]);

//$response = $client->request('GET', 'users.info');
//
//var_dump($response->getBody()->getContents());
//
//var_dump($response);


$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(__DIR__.'/.env');

$slacky = new Slacky();

//$userInfo = new \MatthijsThoolen\Slacky\Endpoint\Users\LookupByEmail('mthoolen@123inkt.nl');
//$response = $userInfo->request($slacky);

$userId = 'UBU1X7T54'; // Matthijs
//$userId = 'UBT22MXN0'; // Frank
//$userInfo = new Info($userId);
//$response = $userInfo->request($slacky);

//$listAll = new \MatthijsThoolen\Slacky\Endpoint\Users\ListAll();
//$response = $listAll->request($slacky);

$listAll = new \MatthijsThoolen\Slacky\Endpoint\Channels\ListAll();
$response = $listAll->request($slacky);

//var_dump($userInfo);

var_dump($response);