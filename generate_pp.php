<?php
session_start();
include('phpqrcode/qrlib.php');
include('config/function_Formcheckandsubmit.php');
include('config/function_html_elements.php');
include('config/function_imageManipulations.php');


$target_layer = imagecreatetruecolor(200,630);
$color = imagecolorallocate($target_layer, 255, 157, 47);
imagefill($target_layer, 0, 0, $color);


// get the result
$result =   $_SESSION['result'];


//add the QR code
$qrFileName = '';
if ($_SESSION['QRcodeFileName'] == ''){
  $target_dir                  = 'uploads/';
  $qrFileName                  =  uniqid('QR_', true); // save as sth unique
  $qrFileName                  = $target_dir . $qrFileName  . '.' . 'png';
  $_SESSION['QRcodeFileName']  = $qrFileName ;
}
else{
  $qrFileName = $_SESSION['QRcodeFileName'];
}
generateQR($qrFileName);


// test if the QR file exists
$end_time       = time()+10;
do {
  if (file_exists($qrFileName)) {
      break;
  }
} while(!(file_exists($qrFileName)) && (time() < $end_time));

$qrImg = image_resize($qrFileName, 'png', 190, 190, $qrFileName);
$qrImg = imagecreatefromjpeg($qrImg);

// get the face image
$faceImg = imagecreatefromjpeg($_SESSION['file_link_face']);

//get the test image
$testImg = imagecreatefromjpeg($_SESSION['file_link_test']);


//create text color
$rand_fg1 =0;
$rand_fg2 =0;
$rand_fg3 =0;
$textcolor = imagecolorallocate($target_layer, $rand_fg1, $rand_fg2, $rand_fg3);

//combine the images
imagecopyresampled($target_layer, $qrImg, 5,5, 0,0, 190,190, 190,190);
imagecopyresampled($target_layer, $faceImg, 5,215, 0,0,190, 190, imagesx($faceImg), imagesy($faceImg));
imagecopyresampled($target_layer, $testImg, 5,425, 0,0, 190,190,imagesx($testImg), imagesy($testImg));
imagestring($target_layer, 4, 60, 200, "code:" . $_SESSION['signature'], $textcolor);
imagestring($target_layer, 4, 60, 410, "code:" . $_SESSION['signature'], $textcolor);
imagestring($target_layer, 3, 17, 615, $result, $textcolor);


header("Content-type: image/jpeg");
imagejpeg($target_layer);



function generateQR($fn){
  if ($_SESSION['message'] == ''){

    $QRmessage='';
    // get the validity date
    $expired = time() + 60*60*24*3;
    $_SESSION['expiredtime'] = $expired;

    //get the outcome
    $result = $_SESSION['result'];

    //get the signature
    $signature = $_SESSION['signature'];

    //string to be encrypted
    $toEncryptedMessage = '{"signature":' . '"' . $signature . '"' . ',"expireOn":' . $expired . ',"result":' . '"' .$result .'"' . '}';
    //$toEncryptedMessage = ' {"expireOn": ' . $expired . ', "result" :' . '"' .$result .'"' . '}';

  //$encryptedMessage = 'hoi';
    //get the key and encrypt
    $key = $_SESSION['key'];
    if ($key != false){
      list($encrypted,$vector) = encrypt($toEncryptedMessage,$key);
      $QRmessage = "squaredant.com/sneltest/verify.php?vector=$vector&locked=$encrypted";
      //$QRmessage = "vector=$vector&locked=$encrypted&randKey=$randomKey";
    }
    else{
      $randomKey = random_int(10000, 99999);
      $randomKey = test_input($randomKey);
      list($encrypted,$vector) = encrypt($toEncryptedMessage,$randomKey);
      $QRmessage = "squaredant.com/sneltest/verify.php?vector=$vector&locked=$encrypted&randKey=$randomKey";
      //$QRmessage = "vector=$vector&locked=$encrypted&randKey=$randomKey";
    //  $QRmessage = "vector=$vector&locked=$encrypted&randKey=$randomKey";
    }
    $_SESSION['message'] = $QRmessage;
  }
  //generate the QR code
  QRcode::png($_SESSION['message'], $fn);
}


function encrypt($e,$k){
  // Store cipher method
  $ciphering = "AES-128-CTR";

  //prepare key
  //$key = $k;//openssl_digest($k, 'SHA256', TRUE);

  // Use OpenSSl encryption method
  $iv_length = openssl_cipher_iv_length($ciphering);
  $options = 0;

  // Use random_bytes() function which gives
  // randomly 16 digit values
  $encryption_iv = random_int(1000000000000000, 9999999999999999);

  // Alternatively, we can use any 16 digit
  // characters or numeric for iv
  //$encryption_key = openssl_digest(php_uname(), 'MD5', TRUE);

  // Encryption of string process starts
  $encryption = openssl_encrypt($e, $ciphering, $k, $options, $encryption_iv);
  $encryption = urlencode($encryption);
  $encryption = str_replace("%", "PeRcEnTaGeS", $encryption);

  //$decryption = openssl_decrypt($encryption, $ciphering, $k, $options, $encryption_iv);

  return array($encryption, $encryption_iv);
}


?>
