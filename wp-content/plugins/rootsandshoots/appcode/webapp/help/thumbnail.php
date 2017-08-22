<?php

function createThumbnail( $fname, $thumbWidth )
{
  $pathToImages = '../../webapp/view/fotouploads/';
  $pathToThumbs = '../../webapp/view/fotouploads/thumbs/';
  // open the directory
  $dir = opendir( $pathToImages );

  // parse path for the extension
  $info = pathinfo($pathToImages . $fname);

  echo "Creating thumbnail for {$fname} <br />";

  // load image and get image size
  $img = imagecreatefromjpeg( "{$pathToImages}{$fname}" );
  $width = imagesx( $img );
  $height = imagesy( $img );

  // calculate thumbnail size
  $new_width = $thumbWidth;
  $new_height = floor( $height * ( $thumbWidth / $width ) );

  // create a new temporary image
  $tmp_img = imagecreatetruecolor( $new_width, $new_height );

  // copy and resize old image into new image
  imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

  // save thumbnail into a file
  imagejpeg( $tmp_img, "{$pathToThumbs}{$fname}" );
  
  // close the directory
  closedir( $dir );
}



?>


