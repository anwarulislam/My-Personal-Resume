<?php
require_once ('vendor/autoload.php');
use \Statickidz\GoogleTranslate;


$targetlanguages = array("de", "fr");


$sourcelanguage = 'en';
$sourcefile = file_get_contents("./strings.xml");

for($i = 0; $i < count($targetlanguages); $i++)
{
	$target = $targetlanguages[$i];
	$targetlanguagefolder = "./lang/values-".$target;
	if (!is_dir($targetlanguagefolder)) mkdir($targetlanguagefolder);
	
	$fh = fopen("./strings.xml", 'r');
	while (!feof($fh)) {
			$line = fgets($fh, 4096);
			if (preg_match('#(.*">)(.*)(</string>)#', $line, $matches))
			{
				$trans = new GoogleTranslate();
				$result = $trans->translate($sourcelanguage, $target, $matches[2]);
				$result = str_replace("'", "\'", $result);
				file_put_contents($targetlanguagefolder."/strings.xml", $matches[1].$result.$matches[3]."\n", FILE_APPEND);
			}
			else file_put_contents($targetlanguagefolder."/strings.xml", $line, FILE_APPEND);
		}
		fclose($fh);
}
?>