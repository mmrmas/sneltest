<?php

// set links and variables
include('config/function_Formcheckandsubmit.php');
include('config/function_html_elements.php');

// variables
$expire = '';
$result = '';


session_start();

$action      =  htmlspecialchars($_SERVER['PHP_SELF']);
$page_head   =  html_header("about", ' ');

echo <<<EOL
<!doctype html>
$page_head
<body>
<header>
   <div class = "brand__bg">
      <h2>Privacy statement</h2>
    </div>
</header>
EOL;
topnav('test');
echo <<< EOL
   <div class = "content">
   <div class ="checkbox_container">
    <text class = "checkbox_box" ></text>
     <text class = "checkbox_box" > We think that privacy drives the success of health measures and take it therefore very seriously. </text>
   </div>
   <div class ="checkbox_container">
     <text class = "checkbox_box" ></text>
     <text class = "checkbox_box" >The infomormation that we collect is only the information that you choose to share in the "Create Passport" page. </text>
   </div>
   <div class ="checkbox_container">
     <text class = "checkbox_box" ></text>
     <text class = "checkbox_box" >Your information is only stored in your passport and can be (optionally) securely protected. </text>
   </div>
    <div class ="checkbox_container">
      <text class = "checkbox_box" ></text>
      <text class = "checkbox_box" >We do not collect, record or store any information. Even if you do not hit the "delete" button after making you passport, your information is removed within one day.</text>
    </div>
    <div class ="checkbox_container">
      <text class = "checkbox_box" ></text>
      <text class = "checkbox_box" >We do not collect or store your self-test results. </text>
    </div>
    <div class ="checkbox_container">
      <text class = "checkbox_box" ></text>
      <text class = "checkbox_box" > After securing, you information is not accessible for anyone, including us. It can only be made visible by you. </text>
    </div>
     <div class ="checkbox_container">
       <text class = "checkbox_box" ></text>
       <text class = "checkbox_box" > You own your own data in your passport. This is privacy by design. </text>
     </div>
   </div>
</body>
</html>
EOL;



?>
