<?php

// parameters
$hubVerifyToken = 'bot-tr';
$accessToken = "EAARaXjh2ohIBAJz5MJUdbC6LZCacNud2izQTaNC1RXyo2DXhARPiC0Ii8NRLMWjrURb8YPZBkdq8wBBhkIOFpHcjEudqNGh1dZBcVZCszgESRC7FYwDF83UnrHdJRaOsxzkni3L4Q0hyJaQrjmu5YARZCikue67gl0CQjLNxvhjVL3avAJuDD";

// check token at setup
if ($_REQUEST['hub_verify_token'] === $hubVerifyToken) {
  echo $_REQUEST['hub_challenge'];
  exit;
}


// handle bot's anwser
$input = json_decode(file_get_contents('php://input'), true);
$senderId = $input['entry'][0]['messaging'][0]['sender']['id'];
$messageText = $input['entry'][0]['messaging'][0]['message']['text'];
$response = null;


//set Message
   $answer = $messageText;


if($messageText == 'hi') {
    $answer = 'oi hi dili ken?';
}



//send message to facebook bot
$response = [
    'recipient' => [ 'id' => $senderId ],
    'message' => [ 'text' => $answer ]
];
$ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
if(!empty($input)){
$result = curl_exec($ch);
}
curl_close($ch);