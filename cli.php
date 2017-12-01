<?php

include __DIR__ . '/vendor/autoload.php';

$clientId = getenv('GENOA_CLIENT_ID');
$secretId = getenv('GENOA_SECRET_ID');

$publisherId = 1;

if (!$clientId) {
  throw new \Exception('Missing client id');
}

if (!$secretId) {
  throw new \Exception('Missing secret id');
}

$genoaClient = new \genoa\Client($clientId, $secretId);
$genoaContent = new \genoa\service\Content($genoaClient, $publisherId);

$result = $genoaContent->getContentById(424991);

//$result = $genoaContent->getLatestContents();

//$result = $genoaContent->getCategoryContents(14);

//$result = $genoaContent->getDeletedContents();

//https://i.imgur.com/BG1jG7O.png

// /home/augusto/Downloads/genoa_thumb_updated.png

//$result = $genoaContent->updateHighlightThumbnail(424991, '/app/genoa_thumb_updated.png', 'image/png', 'udpated_thumbnail.png');


print_r($result);

