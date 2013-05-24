<?php
$save_to="thumbs/restful.jpg";
$im = new imagick('docs/restful.pdf');
#$img->scaleImage(800,0);
$im->setImageFormat( "jpg" );
header( "Content-Type: image/jpeg" );
#$img->writeImage($save_to);
echo $im;
?>
