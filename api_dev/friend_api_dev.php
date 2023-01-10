<?php 

if($action == "send") return $this->run("friend/send_friend", array("uid_user_friend"=> $params));
if($action == "accept") return $this->run("friend/accept_friend", array("uid_friend"=> $params));
if($action == "cancel") return $this->run("friend/cancel_friend", array("uid_friend"=> $params));


$this->loadModel("Friend");

/*neu request hien thi tat ca ban be*/
if($params == "")
{
  $this->Friend->cond("status", "1");
  $this->Friend->cond("id_user", $this->CurrentUser->id);
  $this->Friend->cond("id_user_friend", $this->CurrentUser->id, array("combine"=> "OR"));
  $array_friend = $this->Friend->get();
  echo json_encode($array_friend);

}

/*neu request hien thi yeu cau da gui*/
if($params == "sent")
{
  $this->Friend->cond("status", "0");
  $this->Friend->cond("id_user", $this->CurrentUser->id);
  $array_friend = $this->Friend->get();
  echo json_encode($array_friend);
}

/*neu receive hien thi yeu cau da nhan*/
if($params == "receive")
{
  $this->Friend->cond("status", "0");
  $this->Friend->cond("id_user_friend", $this->CurrentUser->id);
  $array_friend = $this->Friend->get();
  echo json_encode($array_friend);
}

?>