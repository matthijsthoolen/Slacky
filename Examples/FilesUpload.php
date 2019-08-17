<?php

use MatthijsThoolen\Slacky\Endpoint\Files\Upload;
use MatthijsThoolen\Slacky\Model\File\File;
use MatthijsThoolen\Slacky\SlackyFactory;

require_once('head.php');

$file = new File();
$file->setTitle('Titel voor het bericht')
    ->setInitialComment('Dit is een file die is geupload als plaintext')
    ->setFilename('voorbeeld bestand')
    ->setContent('Dit is de content van de file.')
    ->addChannel('CHBTBLNMP');

// Print request
echo '<pre>' . var_dump($file) . '</pre>';

/** @var Upload $filesUpload */
$filesUpload = SlackyFactory::make(Upload::class);
$response    = $filesUpload->setFile($file)->send();

// Print response
echo '<pre>';
var_dump($response);
echo '</pre>';
