<?php



function java_error($message, $newpage){
echo <<<EOL
		<script type = "text/javascript">
		alert("$message");
		window.location.href = "$newpage";
		</script>
EOL;
}




if (!function_exists('html_header')) {
  function html_header($page, $links){
  $output = "
    <html lang = \"en\">
    <head>
    	<title>$page</title>
    	<meta charset=\"utf-8\">
    	<meta name=\"description\" content=\"Lateral Flow Self test Reports\">
    	<meta name=\"author\" content=\"SquaredAnt\">
    	<link rel=\"stylesheet\" href=\"css/style.css\">
      $links
    </head>";
    return $output;
  }
}



if (!function_exists('topnav')) {
  function topnav($in){
    // add sample
    $create = '<a href="register.php">Create Passport</a>';

    // about
    $about = '<a href="about.php">About the passport</a>';

    // contact
    $contact = '<a href="contact.php">Get in touch</a>';

		// privacy statement
		$privacy = '<a href="privacy.php">Privacy statement</a>';


echo <<< EOL
		<div class= "topnavbg"></div>
    <div class="topnav">
    <b class = "user" >welcome!</b>
    <a class = "user" href="leave.php">Reset</a>
    <div class="dropdown">
      <button class="dropbtn">More info</button>
      <div class="dropdown-content">
          $create
          $about
          $contact
          $privacy
    	</div>
    </div>
  </div>
EOL;
  }
}

function rand_color() {
    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}
 ?>
