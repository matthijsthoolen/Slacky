<?php

use MatthijsThoolen\Slacky\Endpoint\Channels\ListAll;
use MatthijsThoolen\Slacky\Slacky;
use MatthijsThoolen\Slacky\SlackyFactory as SlackyFactory;

require_once('head.php');

$slackToken = getenv('SLACK_BOT_TOKEN');
$slacky     = new Slacky($slackToken);

$listAllChannel = SlackyFactory::build(ListAll::class);
$response       = $listAllChannel->send();

echo '<pre>';
var_dump($response->getObject());
echo '</pre>';
