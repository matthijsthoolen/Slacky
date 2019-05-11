<?php

require_once('head.php');

use MatthijsThoolen\Slacky\Endpoint\Chat\PostMessage;
use MatthijsThoolen\Slacky\Model\Message\Composition\TextObject;
use MatthijsThoolen\Slacky\Model\Message\Message;
use MatthijsThoolen\Slacky\Model\Message\Block\SectionBlock;
use MatthijsThoolen\Slacky\SlackyFactory;

$message = new Message();
$message->setChannel('#random');
$message->setText('Hallo iedereen, samengevat!');

// Optionally a TextObject can be created.
//$textObject = new TextObject();
//$textObject->setText('Hallo iedereen!');

$textBlock = new SectionBlock();
// Sets the text, use setTextObject to add a already generated textObject
$textBlock->setText('Hallo iedereen, wat fijn dat je er bent!');
$message->addBlock($textBlock);

/** @var PostMessage $postMessage */
$postMessage = SlackyFactory::build(PostMessage::class);
$response = $postMessage->setMessage($message)->send();

// Print request
echo '<pre>' . json_encode($message, JSON_PRETTY_PRINT) . '</pre>';

// Print response
echo '<pre>';
var_dump($response);
echo '</pre>';
