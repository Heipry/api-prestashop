<?php
require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;

$url = 'https://www.tapasrioja.es';
$apiUri = '/api';
$uri = '/orders';
$queryParams = array(
    'ws_key' => 'MQAL54DGYWWG1KLK5TGKLKYLEMDL35J7',
    'limit' => '1,3'
);
$client = new Client(array('base_uri' => $url));
$response = $client->request(
    'GET', 
    sprintf(
        '%s%s?%s',
        $apiUri,
        $uri,
        http_build_query($queryParams)
    )
);
echo (string)$response->getBody();