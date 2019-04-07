<?php

use MatthijsThoolen\Slacky\Endpoint\Im\ListAll;
use MatthijsThoolen\Slacky\Slacky;

require_once('head.php');

$slackToken = getenv('SLACK_BOT_TOKEN');
$slacky     = new Slacky($slackToken);

$listAll = new ListAll();
$response = $slacky->sendRequest($listAll);

echo '<pre>';
var_dump($response);
echo '</pre>';