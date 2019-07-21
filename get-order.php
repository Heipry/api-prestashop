<?php
require __DIR__ . '/vendor/autoload.php';
use GuzzleHttp\Client;
$url = 'https://www.tapasrioja.es';
$apiUri = '/api';
$uri = '/orders';
$queryParams = array(
    'ws_key' => 'MQAL54DGYWWG1KLK5TGKLKYLEMDL35J7',
);
$id = 44449;
$client = new Client(array('base_uri' => $url));
$response = $client->request(
	'GET', 
	sprintf(
		'%s%s?%s', 
		$apiUri, 
		$uri.'/'.$id, 
		http_build_query($queryParams)
	)
);
function object2array($object) { return @json_decode(@json_encode($object),1); } 
$string=(string)$response->getBody();
$xml = simplexml_load_string($string);


if ($xml->order->id_carrier=='299' || $xml->order->id_carrier=='446' || $xml->order->id_carrier=='4004') {
	echo $xml->order->shipping_number;
}elseif($xml->order->id_carrier==430){
	echo "Lo sentimos, GLS aún no nos ha pasado un nº de seguimiento";	

}else{
	echo "LLama a tu agencia TXT más cercana";
}
echo $xml->order->id_carrier;
print_r($string);