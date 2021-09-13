<?php

// test form input
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function make_readible(&$item1, $value){
  $item1 = htmlspecialchars_decode($item1);
}

?>
