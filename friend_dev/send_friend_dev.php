<?php

$uid_user_friend = "";
if(isset($_GET["member"])) $uid_user_friend = $_GET["member"];

if($uid_user_friend == "") exit("invalid_friend");

/*request send friend from api*/	
$this->loadLib("Api");
$array_api_friend = NULL;
$array_api_friend["token_action"] = $this->Token->get(array("data" =>"friend","action" =>"send", "params" => $uid_user_friend));
$array_api_friend["token_user"]=$this->CurrentUser->token_user;

$str_result = $this->Api->send($array_api_friend);
echo $str_result;

?>