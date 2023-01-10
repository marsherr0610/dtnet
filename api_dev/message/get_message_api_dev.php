<?php

if($uid_user_friend == "") exit(json_encode(array("result"=>"false", "msg"=>"no_friend")));
$this->loadModel("Message");
$this->Message->cond("uid_user_friend", $uid_user_friend);
$array_message = $this->Message->get();

echo json_encode(array("result"=>"ok", "data"=>$array_message));

?>