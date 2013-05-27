<?php
function FN_THUMBNAIL($origen,$destino)
{
	
	$im = new Imagick($origen);
	//$img->scaleImage(800,0);
	$im->setImageFormat( "jpg" );
	//$im->writeImage($save_to);
	file_put_contents($destino, $im);
	//header( "Content-Type: image/jpeg" );
	//echo $im;
}
?>