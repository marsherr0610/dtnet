<?php 

if($action == "get_friend") return $this->run("message/get_friend");
if($action == "get") return $this->run("message/get_message", array("uid_user_friend"=> $params));
if($action == "send") return $this->run("message/send_message", array("uid_user_friend"=> $params));

?>