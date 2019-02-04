<?php

require_once ('/var/www/web5612/html/translate/vendor/autoload.php');
use \Statickidz\GoogleTranslate;

$source = 'en';
$target = 'de';
$text = 'This is a test.';

$trans = new GoogleTranslate();
$result = $trans->translate($source, $target, $text);

echo $result;

?>