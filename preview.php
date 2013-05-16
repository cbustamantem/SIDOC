<?php

$im = new imagick('docs/restful.pdf');
$img->scaleImage(800,0);
$im->setImageFormat( "jpg" );
header( "Content-Type: image/jpeg" );
echo $im;
$img->writeImage($save_to);
?>