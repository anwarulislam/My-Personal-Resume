<?php

$auth = array();

$auth[] = "Client-Service: compilation_service";
$auth[] = "Username: atiab";
$auth[] = "Token: totapakhi";

$data = array(
	"code" => $_POST['mainCode'],
	"input" => $_POST['inputValue'],
	"language" => $_POST['language'],
	"hash" => $_POST['hashCode'],
);

$string = http_build_query($data);

//initialize session
$url = "http://18.211.204.164/index.php/compiler/create_submission";
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $auth);


$response = curl_exec($ch);

curl_close($ch);

echo $response;