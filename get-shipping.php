<?php
require __DIR__ . '/vendor/autoload.php';
use GuzzleHttp\Client;
$url = 'https://www.tapasrioja.es';
$apiUri = '/api';
$uri = '/orders';
$queryParams = array(
    'ws_key' => 'MQAL54DGYWWG1KLK5TGKLKYLEMDL35J7',
);
if (is_null($_GET['id'])) {
header('Location: ./shippingById.php');
}
$id = $_GET['id'];

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
$string=(string)$response->getBody();
$xml = simplexml_load_string($string);
if ($xml->order->current_state == 6) {
	echo "Este pedido ha sido cancelado";
}elseif ($xml->order->delivery_date == '0000-00-00 00:00:00') {
	echo "El pedido aún no ha sido recogido de nuestras instalaciones";
}else{
	if ($xml->order->id_carrier=='299' || $xml->order->id_carrier=='446' || $xml->order->id_carrier=='4004') {
		echo "Enviado con MRW el: ".$xml->order->delivery_date.'<br> Realiza seguimiento: ' ;
		echo '<a href="https://www.mrw.es/seguimiento_envios/MRW_resultados_consultas.asp?modo=nacional&envio='.$xml->order->shipping_number.'">'.$xml->order->shipping_number.'</a>';
	}elseif($xml->order->id_carrier==430){
		echo "Enviado con GLS el: ".$xml->order->delivery_date.'<br> ' ;
		echo "Lo sentimos, GLS aún no nos ha pasado un nº de seguimiento";	

	}else{
		echo "Enviado el: ".$xml->order->delivery_date.'<br> Si ya han pasado 4 o 5 días quizás puedas ' ;
		echo '<a href="https://txt.es/delegacionestxt/#titledelegaciones"> llamar a tu agencia TXT más cercana</a>';
	}
}
echo '<hr><br><a href="shippingByReference.html">Buscar otro pedido</a>';
print_r($string);