<?php
$uid_user_friend = "";
if(isset($_GET["friend"])) $uid_user_friend = $_GET["friend"];
 if($uid_user_friend == "") exit(json_encode(array("result"=>"false", "msg"=>"no_friend")));

/*request  message from api*/	
$this->loadLib("Api");
$array_api_message = NULL;
$array_api_message["token_action"] = $this->Token->get(array("data" =>"message","action" =>"get", "params" => $uid_user_friend));
$array_api_message["token_user"]=$this->CurrentUser->token_user;

$str_result = $this->Api->send($array_api_message);
echo $str_result;

?>