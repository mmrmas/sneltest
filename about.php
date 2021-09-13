<?php
// set links and variables
include('config/function_Formcheckandsubmit.php');
include('config/function_html_elements.php');


session_start();

$action      =  htmlspecialchars($_SERVER['PHP_SELF']);
$page_head   =  html_header("about", ' ');

echo <<<EOL
<!doctype html>
$page_head
<body>
<header>
   <div class = "brand__bg">
      <h2>About the passport</h2>
    </div>
</header>
EOL;
topnav('test');
echo <<< EOL
   <div class = "content">
     <div class ="checkbox_container">
       <text class = "checkbox_box" >What is the passport?</text>
       <text class = "checkbox_box" >The passport is a digital record of a COVID-19 self-test. It holds pictures of a self-test result and QR code with the result of the test. The QR code can be scanned by an on-line QR-code scanner and is valid for 3 days. </text>
     </div>

     <div class ="checkbox_container">
       <text class = "checkbox_box" >For who is this useful?</text>
       <text class = "checkbox_box" >Visitors, students and travelers can generate a passport, and the result and the validity of a recent self-test can be shared with others. This is useful to monitor COVID-19 incidents, create awareness and prevent outbreaks early. </text>
     </div>

     <div class ="checkbox_container">
       <text class = "checkbox_box" >How do I make it?</text>
       <text class = "checkbox_box" >Do a COVID-19 self-test. After that, grab a mobile phone and follow the steps <a href="register.php">here</a>. O, and you also need a pencil to write down your signature code.</text>
     </div>

     <div class ="checkbox_container">
       <text class = "checkbox_box" >A signature code? Why?</text>
       <text class = "checkbox_box" >To prevent the re-use of images, we ask you to write down a random code, that is visible on the picture of the test. </text>
     </div>

     <div class ="checkbox_container">
       <text class = "checkbox_box" >How secure is the passport?</text>
       <text class = "checkbox_box" >Self-test data is not fully reliable: it is easy to see how one can cheat. We therefore recommend to use the passport within communities with a storng incentive to remain COVID-free, such as schools, universities, sportclubs and camps, music and arts societies,for instance.</text>
     </div>

     <div class ="checkbox_container">
       <text class = "checkbox_box" >How long is the passport valid?</text>
       <text class = "checkbox_box" >The passport is valid for 3 days after the moment of creation. For three days it can be scanned and shared, and after then, scanning will not show results any longer. </text>
     </div>

     <div class ="checkbox_container">
       <text class = "checkbox_box" >What information is stored?</text>
       <text class = "checkbox_box" >The passport combines a selfie and a picture of a test, to identify the individual and the self-test result. The QR-code holds the result of the stest, and the expiry date of the result.</text>
     </div>

     <div class ="checkbox_container">
       <text class = "checkbox_box" >Where is the information stored?</text>
       <text class = "checkbox_box" >All information is stored inside the passport. No personal information, location, health or disease information is stored on our servers in our possion. For practical purposes, pictures are stored briefly on our server. You can choose to delete these after generating your passport. Otherwise they will be  permanently deleted within one day. </text>
     </div>

     <div class ="checkbox_container">
       <text class = "checkbox_box" >How secure is the passport?</text>
       <text class = "checkbox_box" >The passport is only presented to you, the user, who will download the passport after creating it.  Information in the QR code can be optionally secured with a security code, so that only you will be able to grant access to the result and the validity of the passport when the QR code is shared with others. </text>
     </div>

     <div class ="checkbox_container">
       <text class = "checkbox_box" >How can we be sure that information is correct?</text>
       <text class = "checkbox_box" >Self-tests are a powerfull and important tool to prevent disease when they are accessible. We believe that individuals, the users of the tests, can record correct information from the correct self-tests, as guided by the testing providers. </text>
     </div>

     <div class ="checkbox_container">
       <text class = "checkbox_box" >Why would this passport generate trust?</text>
       <text class = "checkbox_box" >We aim to lower the threshld for self-testing. When you, the user, are able to personaly choose to share information regarding your own health, you may be more enthusiastic about self-testing.
       </text>
     </div>

     <div class ="checkbox_container">
       <text class = "checkbox_box" >Why not just doing self-test on the spot, when I need one?</text>
       <text class = "checkbox_box" >A negative result of a COVID-19 self-test is generally accepted to be valid for 3 days. This result can thus be re-used for three days, and can be accepted by more then one organization. As an additional advantage, when a large organization requires self-testing by, for insance, employees, the tests can be performed in private, and test reports can be reviewed conveneiently at any time or location during office hours. </text>
     </div>


   </div>
</body>
</html>
EOL;



?>
