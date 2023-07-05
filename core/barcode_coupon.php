<?php
session_start();
header('Content-type: image/jpeg');
//$text = $_SESSION['c_id1'];
$text = $_GET['code'];
//$text='HUNGER10';
$fontsize =40;
$fontsize1 =8;
$img_width=300;
$img_height=60;
$img = imagecreate($img_width, $img_height);
imagecolorallocate($img, 255,255,255);
$textcolor = imagecolorallocate($img, 0, 0, 0);

/* for($x=1; $x<=70; $x++){
$x1= rand(1, 100);
$y1= rand(1, 100);
$x2= rand(1, 100);
$y2= rand(1, 100);

imageline($img, $x1, $y1, $x2, $y2, $textcolor);
}
 */

imagettftext($img, $fontsize, 0, 5, 45, $textcolor, 'fonts/free3of9.ttf', $text);
imagettftext($img, $fontsize1, 0, 20,55, $textcolor, 'fonts/Roboto-Regular.ttf', $text);
imagejpeg($img);


?>