

<html>
<head>
    <title>Image</title>
</head>
<body>
<form action="/action_page.php">
  name<br>
  <input type="text" name="name" value="Anonymous "><br>
  text :<br>
  <input type="text" name="text" value=""><br><br>
  <input type="submit" value="Submit">
</form>
<?php
// Set the content-type
//header('Content-Type: image/png');

//image output name
$output = 'envN.png';

$source = 'env.png';
$image_info = getimagesize($source);
$imgHeight = $image_info[1]; //630
$imgWidth = $image_info[0];  //840

// Create the image
//$im = imagecreatetruecolor($imgHeight, $imgWidth);
$im = imagecreatefrompng($source);

// Create some colors
$color = [
    'white' => imagecolorallocate($im, 255, 255, 255),
    'grey' => imagecolorallocate($im, 128, 128, 128),
    'black' => imagecolorallocate($im, 0, 0, 0),
];

// Replace path by your own font path
$font = [
    'roboto' => dirname(__FILE__) . '/roboto.ttf'
];

//rectengle maker
//imagefilledrectangle($im, 0, 0, 399, 29, $color['white']);


//some settings for text
$fontsize = 18;
$rotation = 0;
$x = 20;
$y = 30;

// Text params
$name = 'Anwarul Islam';
$text = 'this is simple paragraph for checking message from hubby or fav one. and im checking that how are you borther';
$drawFrame = array(10,$imgHeight/2,$imgWidth-10,$imgHeight-$imgHeight/2);
print_r($drawFrame);
$lineHeight = 1;
$wordSpacing = ' ';
$hAlign = 0; // -1:left  0:center 1:right
$vAlign = 0; // -1:top  0:middle 1:bottom


// Add some shadow to the text
imagettftext($im, $fontsize, $rotation, $x++, $y++, $color['grey'], $font['roboto'], $name);

// Add the text
imagettftext($im, $fontsize, $rotation, $x, $y, $color['black'], $font['roboto'], $name);


function wrapimagettftext($img, $fontSize, $drawFrame, $textColor,$fontType, $text, $lineHeight='',$wordSpacing='',$hAlign=0,$vAlign=0) {

    if($wordSpacing===' ' || $wordSpacing==='') {
        $size = imagettfbbox($fontSize, 0, $fontType, ' ');
        $wordSpacing=abs($size[4]-$size[0]);
    }
    $size = imagettfbbox($fontSize, 0, $fontType, 'Zltfgyjp');
    $baseHeight=abs($size[5]-$size[1]);
    $size = imagettfbbox($fontSize, 0, $fontType, 'Zltf');
    $topHeight=abs($size[5]-$size[1]);

    if($lineHeight==='' || $lineHeight==='') {
        $lineHeight=$baseHeight*110/100;
    } else if(is_string($lineHeight) && $lineHeight{strlen($lineHeight)-1}==='%') {
        $lineHeight=floatVal(substr($lineHeight,0,-1));
        $lineHeight=$baseHeight*$lineHeight/100;
    } else {

    }

    $usableWidth=$drawFrame[2]-$drawFrame[0];
    $usableHeight=$drawFrame[3]-$drawFrame[1];

    $leftX=$drawFrame[0];
    $centerX=$drawFrame[0]+$usableWidth/2;
    $rightX=$drawFrame[0]+$usableWidth;

    $topY=$drawFrame[1];
    $centerY=$drawFrame[1]+$usableHeight/2;
    $bottomY=$drawFrame[1]+$usableHeight;

    $text = explode(" ", $text);

    $line_w=-$wordSpacing;
    $line_h=0;
    $total_w=0;
    $total_h=0;
    $total_lines=0;

    $toWrite=array();
    $pendingLastLine=array();

    for($i=0;$i<count($text);$i++) {
        $size = imagettfbbox($fontSize, 0, $fontType, $text[$i]);

        $width = abs($size[4] - $size[0]);
        $height = abs($size[5] - $size[1]);

        $x = -$size[0]-$width/2;
        $y = $size[1]+$height/2;

        if($line_w+$wordSpacing+$width>$usableWidth) {
            $lastLineW=$line_w;
            $lastLineH=$line_h;

            if($total_w<$lastLineW) $total_w=$lastLineW;
            $total_h+=$lineHeight;

            foreach($pendingLastLine as $aPendingWord) {

                if($hAlign<0) $tx=$leftX+$aPendingWord['tx'];
                else if($hAlign>0) $tx=$rightX-$lastLineW+$aPendingWord['tx'];
                else if($hAlign==0) $tx=$centerX-$lastLineW/2+$aPendingWord['tx'];

                $toWrite[]=array('line'=>$total_lines,'x'=>$tx,'y'=>$total_h,'txt'=>$aPendingWord['txt']);
            }
            $pendingLastLine=array();

            $total_lines++;
            $line_w=$width;
            $line_h=$height;

            $pendingLastLine[]=array('tx'=>0,'w'=>$width,'h'=>$height,'x'=>$x,'y'=>$y,'txt'=>$text[$i]);
        } else {

            $line_w+=$wordSpacing;
            $pendingLastLine[]=array('tx'=>$line_w,'h'=>$width,'w'=>$height,'x'=>$x,'y'=>$y,'txt'=>$text[$i]);
            $line_w+=$width;
            if($line_h<$height) $line_h=$height;
        }
    }

    $lastLineW=$line_w;
    $lastLineH=$line_h;

    if($total_w<$lastLineW) $total_w=$lastLineW;
    $total_h+=$lineHeight;

    foreach($pendingLastLine as $aPendingWord) {

        if($hAlign<0) $tx=$leftX+$aPendingWord['tx'];
        else if($hAlign>0) $tx=$rightX-$lastLineW+$aPendingWord['tx'];
        else if($hAlign==0) $tx=$centerX-$lastLineW/2+$aPendingWord['tx'];

        $toWrite[]=array('line'=>$total_lines,'x'=>$tx,'y'=>$total_h,'txt'=>$aPendingWord['txt']);
    }
    $pendingLastLine=array();
    $total_lines++;

    $total_h+=$lineHeight-$topHeight;

    foreach($toWrite as $aWord) {

        $posx = $aWord['x'];

        if($vAlign<0) $posy=$topY+$aWord['y'];
        else if($vAlign>0) $posy=$bottomY-$total_h+$aWord['y'];
        else if($vAlign==0) $posy=$centerY-$total_h/2+$aWord['y'];

        imagettftext($img, $fontSize, 0, $posx, $posy , $textColor, $fontType, $aWord['txt']);

    }
}

wrapimagettftext($im, $fontsize, $drawFrame, $color['black'], $font['roboto'], $text, '100%',' ',$hAlign,$vAlign);

// Using imagepng() results in clearer text compared with imagejpeg()
imagepng($im, $output);
?>

<img src="<?php echo $output ?>" alt="">
</body>
</html>