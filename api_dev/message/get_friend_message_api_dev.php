<?php

/*request friend from api*/	
$this->loadLib("Api");
$array_api_friend = NULL;
$array_api_friend["token_action"] = $this->MyString->jwt(array("data" =>"friend","action" =>"list", "params" => $action));
$array_api_friend["token_user"]=$this->CurrentUser->token_user;

// $str_data = $this->Api->send($array_api_friend);

echo $this->Api->send($array_api_friend);

?>