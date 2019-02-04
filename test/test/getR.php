<?php

$auth = array();

$auth[] = "Client-Service: compilation_service";
$auth[] = "Username: atiab";
$auth[] = "Token: totapakhi";

$hashCode = $_POST['hashCode'];
//$hashCode = 'wow';

//initialize session
$url = "http://18.211.204.164/compiler/index.php/compiler/get_submission_by_hash/".$hashCode;
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $auth);


$response = curl_exec($ch);

curl_close($ch);



print_r($response);