<?php 
$data = "https://cifpcarballeira.com/moodle/mod/assign/view.php?id=124774";


$api = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($data);

$ch = curl_init();

//Configura el curl para mandar la Request
curl_setopt($ch, CURLOPT_URL, $api);

//Configura el curl para devolver la Response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$qrImage = curl_exec($ch);
curl_close($ch);
header("Content-Type: image/png");

echo $qrImage;
