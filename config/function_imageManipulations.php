<?php

function image_resize($file_name, $extension, $width, $height, $destination) {
  $new_width = $width;
  $new_height = $height;
  list($wid, $ht) = getimagesize($file_name);
  $r = $wid / $ht;
  if ($width/$height > $r) {
     $new_width = $height*$r;
     $new_height = $height;
  }
  else {
     $new_height = $width/$r;
     $new_width = $width;
  }

  if (preg_match('/(jpg|jpeg)/i', $extension)){
    $source = imagecreatefromjpeg($file_name);
    $bg = imagecreatetruecolor($new_width, $new_height);
    imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
    imagealphablending($bg, TRUE);
    imagecopyresampled($bg, $source, 0, 0, 0, 0, $new_width, $new_height, $wid, $ht);
    imagedestroy($source);
    $quality = 75; // 0 = worst / smaller file, 100 = better / bigger file
    imagejpeg($bg, $destination, $quality);
    imagedestroy($bg);
    return $destination;
  }
  else if(preg_match('/png/i', $extension)){
    $source = imagecreatefrompng($file_name);
    $bg = imagecreatetruecolor($new_width, $new_height);
    imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
    imagealphablending($bg, TRUE);
    imagecopyresampled($bg, $source, 0, 0, 0, 0, $new_width, $new_height, $wid, $ht);
    imagedestroy($source);
    $quality = 75; // 0 = worst / smaller file, 100 = better / bigger file
    imagejpeg($bg, $destination, $quality);
    imagedestroy($bg);
    return $destination;
  }
}

 ?>
