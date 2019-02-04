<?php

$curl = curl_init();

$link = urlencode('https://translate.google.com/#bn/en/tumi jodi rag');

// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://translate.google.com/%23bn/en/tumi',
    CURLOPT_USERAGENT => 'Codular Sample cURL Request'
));
// Send the request & save response to $resp
 $resp = curl_exec($curl);
 
 echo $resp;
 echo $link;
 
// Close request to clear up some resources
curl_close($curl);