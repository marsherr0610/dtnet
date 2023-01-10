<?php

$uid_friend = "";
if(isset($_GET["friend"])) $uid_friend = $_GET["friend"];

if($uid_friend == "") exit("invalid_friend");

/*request send friend from api*/	
$this->loadLib("Api");
$array_api_friend = NULL;
$array_api_friend["token_action"] = $this->MyString->jwt(array("data" =>"friend","action" =>"accept", "params" => $uid_friend));
$array_api_friend["token_user"]=$this->CurrentUser->token_user;

$str_data = $this->Api->send($array_api_friend);
echo $str_data;


?>