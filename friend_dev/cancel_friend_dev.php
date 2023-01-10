<?php

$id_record = "";
if(isset($_GET["id_record"])) $id_record = $_GET["id_record"];

if($id_record == "") exit("invalid_friend");

/*request send friend from api*/	
$this->loadLib("Api");
$array_api_friend = NULL;
$array_api_friend["token_action"] = $this->MyString->jwt(array("data" =>"friend","action" =>"cancel", "params" => $id_record));
$array_api_friend["token_user"]=$this->CurrentUser->token_user;

$str_data = $this->Api->send($array_api_friend);
echo $str_data;


?>