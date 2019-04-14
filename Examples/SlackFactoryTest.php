<?php

use MatthijsThoolen\Slacky\Model\Channel;
use MatthijsThoolen\Slacky\Model\User;
use MatthijsThoolen\Slacky\SlackyFactory as SlackyFactory;

require __DIR__ . '/../vendor/autoload.php';

require_once('head.php');

$listAllChannel = SlackyFactory::build('Channels.List');
$channels = $listAllChannel->send();

/** @var Channel $channel */
foreach ($channels as $channel) {
    $members = $channel->getMembers();

    echo 'Channel members off: ' . $channel->getName() . '<br>';

    /** @var User $member */
    foreach ($members as $member) {
        echo 'Hi, my name is ' . $member->getName() . '<br>';
    }
}