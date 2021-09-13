<?php

// set links and variables
include('config/function_Formcheckandsubmit.php');
include('config/function_html_elements.php');

$action      =  htmlspecialchars($_SERVER['PHP_SELF']);
$page_head   =  html_header("about", ' ');

echo <<<EOL
<!doctype html>
$page_head
<body>
<header>
   <div class = "brand__bg">
      <h1>Get in touch</h1>
    </div>
</header>
EOL;
topnav('test');
echo <<< EOL
  <div class = "content">
  <div>
    <text>This solution is free of use an 100% secure.</text>
    <text>The solution can be modified for and catered to organizations, if you wish to provide self-test to visitors, employees or students. </text>
    <div></div>
    <a href = "https://www.linkedin.com/in/sam-linsen/">Please get in touch via linkedin</a>
  </div>
  </div>
</body>
</html>
EOL;


?>
