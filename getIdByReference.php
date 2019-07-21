<?php
require __DIR__ . '/vendor/autoload.php';
use GuzzleHttp\Client;
$url = 'https://www.tapasrioja.es';
$apiUri = '/api';
$uri = '/orders';
if (is_null($_GET['N'])) {
header('Location: ./IdByN,html');
}
$n = $_GET['N'];
$queryParams = array(
    'ws_key' => 'MQAL54DGYWWG1KLK5TGKLKYLEMDL35J7',
    'filter[reference]' => $n
);
if (is_null($_GET['N'])) {
header('Location: ./IdByN.html');
}
$n = $_GET['N'];

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
$string=(string)$response->getBody();
$xml = simplexml_load_string($string);

$atributos = $xml->orders->order->attributes();

print_r($string);
if ($xml->orders->order->count()!=1) {
	echo "El número de pedido no es correcto";
}else{
	$id=$atributos['id'];
	header('Location: ./get-shipping.php?id='.$id);
}