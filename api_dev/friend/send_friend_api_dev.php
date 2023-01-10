<?php
function update_friend_list($id_user = "", $username = "", $id_user_friend = "", $status ="0", $UserSetting) 
{

  /*tao thong tin ban moi*/
  $id_user_setting = "";
  $array_friend_list = null;
  $item_status = array("date" => date("Y-m-d H:i:s"), "status"=>$status);
  $array_friend_list[$id_user_friend] = $item_status;

  /*doc du lieu friend_list tu bang user_settings va luu vao bang user_settings*/
  $UserSetting->cond("id_user",  $id_user);
  $array_user_setting = $UserSetting->get();

  if($array_user_setting != null) 
  {
    $id_user_setting = $array_user_setting[0]["id"];

    /*neu da co du lieu thi bo sung them ban moi*/
    if($array_user_setting[0]["friend_list"] != ""){

    
      $friend_list = $array_user_setting[0]["friend_list"];
      
      $array_friend_list = json_decode($friend_list, true);
      $array_friend_list[$id_user_friend] = $item_status;
    }
  }
    /*update lại trường friend_list trong bảng user_settings*/
    $array_data_user_setting = NULL;

    $array_data_user_setting["id"] = $id_user_setting;
    $array_data_user_setting["friend_list"] = json_encode($array_friend_list);
    $array_data_user_setting["id_user"] = $id_user;
    $array_data_user_setting["username"] = $username;

    $UserSetting->save($array_data_user_setting);

}
/*end function update_friend_list($id_user, $id_user_friend) */

$array_friend = null;

/*lay thong tin cua current user*/
$array_friend["id_user"] = $this->CurrentUser->id;
$array_friend["uid_user"] = $this->CurrentUser->uid;
$array_friend["username"] = $this->CurrentUser->username;
$array_friend["user_fullname"] = $this->CurrentUser->fullname;

/*lay thong tin cua friend*/

$array_friend["uid_user_friend"] = $uid_user_friend;

$this->loadModel("User");
$array_user_friend = $this->User->read($uid_user_friend);

if($array_user_friend == null) exit(json_encode(array("result"=>"false", "msg"=>"invalid_friend")));

$array_friend["id_user_friend"] = $array_user_friend["id"];
$array_friend["username_friend"] = $array_user_friend["username"];
$array_friend["user_fullname_friend"] = $array_user_friend["fullname"];

$array_friend["status"] = "0";

$id_user_friend = $array_user_friend["id"];
$username_friend = $array_user_friend["username"];

/*luu du lieu vao bang friends, voi truong hop status = 0*/
$this->loadModel("Friend");
$this->Friend->save($array_friend);

/*luu du lieu vao bang user_settings, trường friend_list, giá trị id, date, status {"$id_user_friend":{"date":"$date","status":"2"}}*/
 
$this->loadModel("UserSetting");

$id_user_send= $this->CurrentUser->id;
$username_send = $this->CurrentUser->username;

/*goi ham update_friend_list de update cho cả người gửi và người nhận*/
update_friend_list($id_user_send, $username_send, $id_user_friend, "2", $this->UserSetting);
update_friend_list($id_user_friend, $username_friend, $id_user_send, "3", $this->UserSetting);


echo json_encode(array("result"=>"ok", "msg"=>"sent_ok"));

?>