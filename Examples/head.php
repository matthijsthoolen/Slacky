<?php

use GuzzleHttp\Client;
use MatthijsThoolen\Slacky\Slacky;
use Symfony\Component\Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

$client = new Client(['base_uri' => 'https://slack.com/api/']);

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');
