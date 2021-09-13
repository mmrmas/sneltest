<?php
session_start();

// set links and variables
include('config/function_Formcheckandsubmit.php');
include('config/function_html_elements.php');

// variables
$expire = '';
$result = '';
$signature = '';
$unlocked = '';
$vector = '';
$locked = '';


//sessions
set_sessions();

//check if we need to stop
if (isset($_GET['logout'])){
  logout();
}

//get the encrypted locked code from the code
if (isset($_GET['locked'])){
  $locked_ori = $_GET['locked'];
  $locked = str_replace("PeRcEnTaGeS","%", $locked_ori);
  $locked = urldecode($locked);
  $_SESSION['lockedGet'] = $locked;
}
else{
  //send away
  java_error("qr not recognized, close window and scan again","verify.php?logout=true");
}

//get the encrypted locked code from the code
if (isset($_GET['vector'])){
  $vector = $_SESSION['vector']  = $_GET['vector'];
}
else{
  //send away
  java_error("qr not recognized, close window and scan again","verify.php?logout=true");
}

//check if there is a random Key so it was not privately locked
//get the encrypted locked code from the code
if (isset($_GET['randKey'])){
  $_SESSION['randKey']  = $_GET['randKey'];
}


// ask for the key
if ($_SESSION['randKey'] != false){
  $decrypt  = $_SESSION['randKey'];
  unlockPrep($decrypt);
}
elseif (isset($_POST['unlockpp']) && $_SESSION['randKey'] == false) {
  $decrypt  = test_input($_POST['key']);
  unlockPrep($decrypt);
}







$action      =  htmlspecialchars($_SERVER['PHP_SELF']);
$page_head   =  html_header("verify test", ' ');

echo <<<EOL
<!doctype html>
$page_head
<body>
<header>
   <div class = "brand__bg">
      <h2>Scan page of self-test COVID-19 passports</h2>
    </div>
</header>
EOL;
topnav('test');
echo <<< EOL
  <div class = "content">
EOL;
  if ($_SESSION['randKey'] == false && $_SESSION['expire'] == false){
echo <<< EOL
  <form method="post" >
    <div class = "form-element">
      <input type="input" id="key" name="key" placeholder="security key" maxlength="8" required>
      <label for="key">Key</label><br>
    </div>
    <div class = "form-element">
     <input type="submit" name="unlockpp" value="unlock code" />
    </div>
  </form>
EOL;
  }

if ($_SESSION['showResult'] != false && $_SESSION['expire'] != false ){
  $expirybool         = 'VALID';
  $bgCol              = 'green';
  $showResult         = $_SESSION['showResult'];
  $signature          = $_SESSION['sign'];
  if ($_SESSION['expire'] < time() ){
    $expirybool = 'EXPIRED';
    $showResult         = 'not applicable';
    $signature          = 'not applicable';
    set_sessions();
  }
  if (preg_match('/positive/i',$_SESSION['showResult'])){
    $bgCol         = 'red';
  }

echo <<< EOL
      <div class ="checkbox_container">
        <text class = "checkbox_box">This self-test report is:</text>
        <div class = "checkbox_box">
          <div class = "progressArrowBox">
            <h3> $expirybool </h3>
          </div>
        </div>
      </div>

      <div class ="checkbox_container">
        <text class = "checkbox_box">Only valid if the hand-written signature is:</text>
        <div class = "checkbox_box">
          <div class = "progressArrowBox">
            <text>  $signature  </text>
          </div>
        </div>
      </div>


      <div class="checkbox_container">
        <text class = "checkbox_box">The result is:</text>
        <div class = "checkbox_box">
          <div class = "progressArrowBox" style="border-radius:5px;background-color:$bgCol">
            <text> $showResult </text>
          </div>
        </div>
      </div>


      <div class = "checkbox_container">
        <div class = "checkbox_box">
          <div class = "imageBox">
            <img class="uploadimage" style="width:50%;" src = "img/sneltestExample.jpg" />
          </div>
        </div>
        <div class = "checkbox_box"> This is an example: the hand-written signature should be clearly visible on the picture of the test. </div>
      </div>




EOL;
}


$date         = date("Y-m-d H:i a");

echo <<< EOL

    </div>
  </body>
</html>
EOL;







function unlockPrep($decrypt){
  //now unlock the message
  $vector         = $_SESSION['vector'];
  $message        = $_SESSION['lockedGet'];
  $unlocked       = unlock($message, $vector, $decrypt);
  $infoObject     = json_decode($unlocked);
  if (!isset($infoObject) ) {
    java_error("wrong key, enter again $decrypt","verify.php?vector=$vector&locked=$locked_ori");
    //java_error("wrong key, enter again","verify.php?logout=true");
  }
  $_SESSION['expire']     = $infoObject->{'expireOn'};
  $_SESSION['showResult'] = $infoObject->{'result'};
  $_SESSION['sign']       = $infoObject->{'signature'};
}


function unlock($u, $v, $k){
    $ciphering = "AES-128-CTR";
    $options = 0;
    $decryption = openssl_decrypt($u, $ciphering, $k, $options, $v);
    return ($decryption);
}


function set_sessions(){
  $_SESSION['lockedGet']        =  '';
  $_SESSION['vector']           =  '';
  $_SESSION['randKey']          =  false;
  $_SESSION['expire']           =  false;
  $_SESSION['showResult']       =  false;
  $_SESSION['sign']             =  false;
}


function logout(){
  session_unset();
  session_destroy();
  session_start();
  set_sessions();
  exit;
}

?>
