<?php

use GuzzleHttp\Client;
use MatthijsThoolen\Slacky\Endpoint\Channels\ListAll;
use MatthijsThoolen\Slacky\Endpoint\Chat\PostMessage;
use MatthijsThoolen\Slacky\Slacky;
use Symfony\Component\Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';

$client = new Client(['base_uri' => 'https://slack.com/api/']);

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env');

$slackToken = getenv('SLACK_BOT_TOKEN');
$slacky = new Slacky($slackToken);

$userId = 'UBU1X7T54'; // Matthijs
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
//
$postMessage = new PostMessage($message);
$response = $slacky->sendRequest($postMessage);

//var_dump($userInfo);

var_dump($response);
