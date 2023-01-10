<?php

$array_friend = "";

$array_friend = $uid_friend;


$this->loadModel("Friend");
$this->Friend->delete($array_friend, "uid");
  
echo "delete successfully";

?>