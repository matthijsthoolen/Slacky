<?php

use MatthijsThoolen\Slacky\SlackyFactory as SlackyFactory;

require __DIR__ . '/../vendor/autoload.php';

$ListAllChannel = SlackyFactory::build('Channels.List');

$test = $ListAllChannel;

