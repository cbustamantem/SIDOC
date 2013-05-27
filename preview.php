<?php
$save_to="/var/www/fundacion/thumbs/oracle.jpg";
$im = new Imagick('docs/oracle.pdf');
//$img->scaleImage(800,0);
$im->setImageFormat( "jpg" );
//$im->writeImage($save_to);
file_put_contents($save_to, $im);
header( "Content-Type: image/jpeg" );
echo $im;


?>