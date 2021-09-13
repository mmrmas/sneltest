<?php
session_start();
logout();

function logout(){
  session_unset();
  session_destroy();
  session_start();
  header('Location: register.php');
}


?>
