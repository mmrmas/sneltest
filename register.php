<?php
session_start();

//safety first: safety net

// Make sure we have a canary set
if (!isset($_SESSION['canary'])) {
    session_regenerate_id(true);
    $_SESSION['canary'] = [
        'birth' => time(),
        'IP' => $_SERVER['REMOTE_ADDR']
    ];
}
if ($_SESSION['canary']['IP'] !== $_SERVER['REMOTE_ADDR']) {
    session_regenerate_id(true);
    // Delete everything:
    foreach (array_keys($_SESSION) as $key) {
        unset($_SESSION[$key]);
    }
    $_SESSION['canary'] = [
        'birth' => time(),
        'IP' => $_SERVER['REMOTE_ADDR']
    ];
}
// Regenerate session ID every five minutes:
if ($_SESSION['canary']['birth'] < time() - 300) {
    session_regenerate_id(true);
    $_SESSION['canary']['birth'] = time();
}

// end of safety net

//add: wait a moment (10 seconds)
// dont'change QR name
// signature shorter
//signature in QR code string
// image recognition attempt??

//html information
$published   = 'https://squaredant.com';
//$published   = '';
$action      =  $published.htmlspecialchars($_SERVER['PHP_SELF']);



// set links and variables
include('config/function_Formcheckandsubmit.php');
include('config/function_html_elements.php');
include('config/function_imageManipulations.php');

//check if we are coming back
if (isset($_GET['notcomplete'])){
  $_SESSION['popup_confirm'] = false; //close the loop of popping up
}

//local variables
$uploadfile   = 'image'; // set later to filename

//side-wide variables
set_sessions();

//check input
if (isset($_POST['add_face'])) {
  $fileId = "face-file";
  $_SESSION['file_link_face']= uploadFile($fileId);
echo <<< EOL
  <script type = "text/javascript">
  function tempAlert(msg,duration)
  {
   var el = document.createElement("div");
   el.setAttribute("style","display:flex;align-items: center;justify-content: center;text-align: center;position:absolute;top:40%;left:30%;width:40%;height:20%;z-index:100;background-color:white;border-radius:15px;border:solid #ED3832 2px;");
   el.innerHTML = msg;
   setTimeout(function(){
    el.parentNode.removeChild(el);
   },duration);
   document.body.appendChild(el);
  }
  tempAlert("please wait for the upload to finish",2000);
  </script>
EOL;
  if ($_SESSION['file_link_face'] != ''){
    $_SESSION['face_set'] = true;
    $face_pressed = 0;
  }
}

if (isset($_POST['add_test'])) {
  $fileId = "test-file";
  $_SESSION['file_link_test'] = uploadFile($fileId);
echo <<< EOL
  <script type = "text/javascript">
  function tempAlert(msg,duration)
  {
   var el = document.createElement("div");
   el.setAttribute("style","display:flex;align-items: center;justify-content: center;text-align: center;position:absolute;top:40%;left:30%;width:40%;height:20%;z-index:100;background-color:white;border-radius:15px;border:solid #ED3832 2px;");
   el.innerHTML = msg;
   setTimeout(function(){
    el.parentNode.removeChild(el);
   },duration);
   document.body.appendChild(el);
  }
  tempAlert("please wait for the upload to finish",2000);
  </script>
EOL;
  if ($_SESSION['file_link_test'] != ''){
    $_SESSION['test_set'] = true;
  }
}

if (isset($_POST['createpp'])){
  $_SESSION['result']   =  test_input($_POST['test']);       //must be filled
  $_SESSION['key']      =  test_input($_POST['key']);        //optional
  $_SESSION['popup_confirm'] = true;
}

//check for the input from the popup
if (isset($_POST['createpp_final']) && $_SESSION['face_set'] == true && $_SESSION['test_set'] == true) {
    $_SESSION['popup_confirm'] = false;
    $_SESSION['passport'] = true;
}
if (isset($_POST['abort'])) {
    $_SESSION['popup_confirm'] = false;
}


if (isset($_POST['logout'])) {
  logout($action);
}


$page_head   =  html_header("register test", ' ');
$signature   =  $_SESSION['signature'];

echo <<<EOL
<!doctype html>
$page_head
<body>
<header>
   <div class = "brand__bg">
      <h2>Create your self-test COVID-19 passport</h2>
    </div>
</header>
EOL;
topnav('test');
echo <<< EOL

  <div class = "content">
    <form method="post" id ="file-select" enctype="multipart/form-data" action="$action">
      <div class ="checkbox_container">
        <label class = "checkbox_box">1.Your selfie.</label>
        <div class = "checkbox_box">
          <div class = "progressArrowBox">
            <label for="face-file" class = "fileupload_cover">upload selfie</label>
            <input class = "fileupload" type="file" name="face-file" id="face-file" onchange="form.submit()" />
          </div>
          <input type = "hidden" name="add_face"/>
        </div>
      </div>
    </form>
EOL;
$file_link_face = $_SESSION['file_link_face'];
if ($file_link_face != ''){
echo <<< EOL
<div class ="checkbox_container">
  <div class = "checkbox_box"></div>
  <div class = "checkbox_box">
    <div class = "imageBox">
        <img class="uploadimage"  src = "$file_link_face" />
        </div>
      </div>
    </div>
EOL;
}








echo <<< EOL
    <form method="post" id ="file-select" enctype="multipart/form-data" action="$action" >
      <div class ="checkbox_container">
        <label class = "checkbox_box">2. Picture of your test.
        </label>
        <div class = "checkbox_box">
          <div class = "progressArrowBox">
            <label for="test-file" class = "fileupload_cover">upload test</label>
            <input class = "fileupload" type="file" name="test-file" id="test-file"  onchange="form.submit()" />
          </div>
          <input type = "hidden" name="add_test"/>
        </div>
      </div>
    </form>





EOL;
$file_link_test = $_SESSION['file_link_test'];
if ($file_link_test != ''){
echo <<< EOL
<div class ="checkbox_container">
  <div class = "checkbox_box"></div>
  <div class = "checkbox_box">
    <div class = "imageBox">
      <img class="uploadimage" src = "$file_link_test" />
    </div>
  </div>
</div>
EOL;
}



echo <<< EOL

    <div class = "checkbox_container">
      <text class = "checkbox_box">  Make sure that this hand-written code is visible*:
          <h3>$signature</h3>
      </text>
      <div class = "checkbox_box"> </div>
    </div>
    <div class = "checkbox_container">
      <text class = "checkbox_box"> write down the code as indicated on this example</text>
      <div class = "checkbox_box"> </div>
    </div>
    <div class = "checkbox_container">
      <div class = "checkbox_box">
        <div class = "imageBox">
          <img class="uploadimage" style="width:50%;" src = "img/sneltestExample.jpg" />
        </div>
      </div>
      <div class = "checkbox_box">  </div>
    </div>


    <form method="post" >
    <div class ="checkbox_container">
      <label class = "checkbox_box">3. Result of test</label>
      <div class = "checkbox_box">
        <div class = "radiobutton">
          <input style = "transform:scale(3)" type="radio" id="positive" name="test" value="positive:infected" required>
          <label style = "transform:translate(20px,0)" for="positive">Positive</label><br>
        </div>
        <div class = "radiobutton">
          <input style = "transform:scale(3)" type="radio" id="negative" name="test" value="negative:not-infected" >
          <label  style = "transform:translate(20px,0)"  for="negative">Negative</label><br>
        </div>
      </div>
    </div>


    <div class = "checkbox_container">
      <label class = "checkbox_box" for="key">4. Security key (optional**) </label>
      <div class = "checkbox_box">
        <div class = "progressArrowBox">
          <input class = "inputfield" type="input" id="key" name="key" placeholder="your key" maxlength="8">
        </div>
      </div>
    </div>


    <div class = "rightalign">
       <input class = "button" type="submit" name="createpp" value="create passport" />
     </div>

    </form>

    <form method="post">
      <div class = "rightalign">
        <input class = "button" type="submit" name="logout" value="reset page" />
      </div>
    </form>

    <div class = "checkbox_container">
      <text class = "checkbox_box">*this code can verify your passport to check the originality of your test picture. </text>
      <div class = "checkbox_box"> </div>
    </div>
    <div class = "checkbox_container">
      <text class = "checkbox_box">** an optional key can encrypt your QR-code, so that your QR-content cannot be read at random.<br> If you choose to encrypt, please remember your code! </text>
        <div class = "checkbox_box"> </div>
    </div>

EOL;

if ($_SESSION['popup_confirm'] == true){
  if ($_SESSION['file_link_face'] != '' && $_SESSION['file_link_test'] != '' && $_SESSION['result'] != false){
    //ask for confirmation
    $key      =   ($_SESSION['key'] != false) ? $_SESSION['key'] : 'no security, everyone can scan';
    $result   =   $_SESSION['result'] ;
echo <<< EOL
      <div class = "popup_bg"/>
      <div class = "popup">
        <div class ="checkbox_container">
          <text class = "checkbox_box">Result of test</text>
          <text class = "checkbox_box">$result</text>
        </div>
        <div class ="checkbox_container">
          <text class = "checkbox_box">Security key</text>
          <text class = "checkbox_box">$key</text>
        </div>
        <div class ="checkbox_container">
          <text class = "checkbox_box">Code <b>(hand-written on your test picture)</b></text>
          <text class = "checkbox_box">$signature</text>
        </div>
        <form method="post">
          <div class ="checkbox_container">
            <div class = "checkbox_box">
              <input class = "button" type="submit" name="createpp_final" value="confirm" />
              <input class = "button" type="submit" name="abort" value="return" />
            </div>
          </div>
        </form>
      </div>
EOL;
  }
  else {
      java_error("some information is missing, please make sure to upload your files and fill the complete form","register.php?notcomplete=true");
  }

}

if ($_SESSION['passport'] == true){
  $_SESSION['final'] = true;
  $filename =  date('Y-m-d-H_i_s',$_SESSION['expiredtime']). '.jpg';
  $message = htmlentities($_SESSION['message']);
  $message = str_replace("PeRcEnTaGeS", "%", $message);
  $message_real = urldecode($message);
echo <<< EOL
        <div class = "popup_bg" />
        <div class = "popup">
          <text> $message </text>
          <div class ="checkbox_container">
            <text class = "checkbox_box">Your file is ready and the result is valid for the next 3 days.</text>
          </div>
          <div class ="checkbox_container">
            <text class = "checkbox_box">You can store the passport by clicking the image or press the "save" button below.</text>
          </div>
          <div class ="checkbox_container">
            <text class = "checkbox_box">In case your result is positive, please wear a mask, verify with a professional, take the necessay precautions, and get well soon!</text>
          </div>
          <div class ="checkbox_container">
            <a class = "checkbox_box" href="generate_pp.php" download="$filename">
              <div class = "progressArrowBox">
                <img class = "passportimage" src = "generate_pp.php" />
              </div>
            </a>
          </div>
          <div class ="checkbox_container">
            <a class = "checkbox_box" href="generate_pp.php" download="$filename">
              <div class = "progressArrowBox">
                <input class = "button" type = "submit" value="save" />
              </div>
            </a>
          </div>
          <form method="post">
            <div class = "progressArrowBox">
              <input class = "button" type="submit" name="logout" style = "width:65%;" value="delete files and close" />
            </div>
          </form>
        </div>
EOL;





echo <<< EOL

EOL;
}


echo <<< EOL
  </div>
    <script src="scripts/index.js"></script>
  </body>
</html>
EOL;


function set_sessions(){
  $_SESSION['file_link_face']  = isset($_SESSION['file_link_face']) ? $_SESSION['file_link_face'] : '';
  $_SESSION['file_link_test']  = isset($_SESSION['file_link_test']) ? $_SESSION['file_link_test'] : '';
  $_SESSION['test_set']        = isset($_SESSION['test_set']) ? $_SESSION['test_set'] : false;
  $_SESSION['face_set']        = isset($_SESSION['face_set']) ? $_SESSION['face_set'] : false;
  $_SESSION['test-file']       = isset($_SESSION['test-file']) ? $_SESSION['test-file'] : '';
  $_SESSION['face-file']       = isset($_SESSION['face-file']) ? $_SESSION['face-file'] : '';
  $_SESSION['result']          = isset($_SESSION['result']) ? $_SESSION['result']  : false;
  $_SESSION['passport']        = isset($_SESSION['passport']) ? $_SESSION['passport']  : false;
  $_SESSION['key']             = isset($_SESSION['key']) ?  $_SESSION['key']  : false;
  $_SESSION['popup_confirm']   = isset($_SESSION['popup_confirm']) ? $_SESSION['popup_confirm']  : false;
  $_SESSION['final']           = isset($_SESSION['final']) ? $_SESSION['final']  : false;
  $_SESSION['expiredtime']     = isset($_SESSION['expiredtime']) ? $_SESSION['expiredtime']  : false;
  $_SESSION['QRcodeFileName']  = isset($_SESSION['QRcodeFileName']) ? $_SESSION['QRcodeFileName'] : '';
  $_SESSION['signature']       = isset($_SESSION['signature']) ? $_SESSION['signature'] : getSignature();
  $_SESSION['message']         = isset($_SESSION['message']) ?  $_SESSION['message'] : '';
}

function logout($a){
  if (isset($_SESSION['file_link_face'])){
    unlink($_SESSION['file_link_face']);
  }
  if (isset($_SESSION['file_link_test'])){
    unlink($_SESSION['file_link_test']);
  }
  if ($_SESSION['QRcodeFileName'] != ''){
    unlink($_SESSION['QRcodeFileName']);
  }
  session_unset();
  session_destroy();
  session_start();
  set_sessions();
  header($a);
}


function uploadFile($fileId){
  // still need to cahnge the file size
  $target_dir     = "uploads/";
  $uploadOk       = 0;
  $target_file    = $target_dir . basename($_FILES[$fileId]["name"]);
  $imageFileType  = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  $imageTemp       = $_FILES[$fileId]["tmp_name"];


  //check if we already created a name for the file, if not make one
  $newTarget_file = '';
  if ($_SESSION[$fileId] != ''){
    $newTarget_file = $_SESSION[$fileId];
  }
  else {
    $uniqueIdentifier  =  uniqid($fileId, true); // save as sth unique
    //$newTarget_file    = $target_dir .  $uniqueIdentifier  . '.' . $imageFileType;
      $newTarget_file    = $target_dir .  $uniqueIdentifier  . '.jpg';
  }

  // Check if image file is a actual image or fake image
  $check = getimagesize($_FILES[$fileId]["tmp_name"]);
  if($check !== false) {
    // Compress size and upload image
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk     = 1;
    $file_link    = $_FILES[$fileId]["tmp_name"];
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }

  // Check if file already exists
  if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }

  // Check file size
  if ($_FILES[$fileId]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }

  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
    java_error ("Sorry, only JPG, JPEG, PNG & GIF files are allowed.", "register.php");
    $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
      java_error("image was not uploaded, try a smaller image (max size = 5 mb)", "https://squaredant.com/sneltest/register.php");
  } else {
    // get the test
    $compressedImage = image_resize($imageTemp, $imageFileType , 190, 190, $newTarget_file);
    if (isset($compressedImage)){
      return $compressedImage;
    }
    else{
      java_error("failed to compress this imgage", "https://squaredant.com/sneltest/register.php");
    }
  }
}


function getSignature(){
  $random_alpha = md5(rand());
  $sign_code = substr($random_alpha, 0, 5);
  return($sign_code);
}

function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

?>
