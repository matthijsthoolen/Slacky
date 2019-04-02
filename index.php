<?php

use MatthijsThoolen\Slacky\Endpoint\Channels\ListAll;
use MatthijsThoolen\Slacky\Endpoint\Chat\PostMessage;
use MatthijsThoolen\Slacky\Endpoint\Users\Info;
use MatthijsThoolen\Slacky\Model\Message;
use MatthijsThoolen\Slacky\Slacky;
use Symfony\Component\Dotenv\Dotenv;

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


$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

$slackToken = getenv('SLACK_BOT_TOKEN');
$slacky = new Slacky($slackToken);

//$userInfo = new \MatthijsThoolen\Slacky\Endpoint\Users\LookupByEmail('mthoolen@123inkt.nl');
//$response = $userInfo->request($slacky);

$userId = 'UBU1X7T54'; // Matthijs
//$userId = 'UBT22MXN0'; // Frank
//$userInfo = new Info($userId);
//$response = $userInfo->request($slacky);

//$listAll = new \MatthijsThoolen\Slacky\Endpoint\Users\ListAll();
//$response = $listAll->request($slacky);

$listAll = new ListAll();
$response = $slacky->sendRequest($listAll);
//
var_dump($response);

$message = new Message([]);
$message->setText('Hello World');
$message->setChannel('GGY2F0AG7');
//
$postMessage = new PostMessage($message);
$response = $slacky->sendRequest($postMessage);

//var_dump($userInfo);

var_dump($response);