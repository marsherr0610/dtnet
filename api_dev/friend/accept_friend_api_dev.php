<?php
function update_friend_list($id_user = "", $username = "", $id_user_friend = "", $UserSetting) 
{
  $id_user_setting = "";
  $array_friend_list = null;
  $array_friend_list[$id_user_friend] = array("date" => date("Y-m-d H:i:s"), "status"=>"1");

  /*doc du lieu tu user_settings va luu vao bang user_friends*/
  $UserSetting->cond("id_user",  $id_user);
  $array_user_setting = $UserSetting->get();

  if($array_user_setting != null) 
  {
    $id_user_setting = $array_user_setting[0]["id"];

    if($array_user_setting[0]["friend_list"] != ""){

    
      $friend_list = $array_user_setting[0]["friend_list"];
      
      $array_friend_list = json_decode($friend_list, true);
      $array_friend_list[$id_user_friend] = array("date" => date("Y-m-d H:i:s"), "status"=>"1");
    }
  }
    /*update vào bảng user_settings*/
    $array_data_user_setting = NULL;

    $array_data_user_setting["id"] = $id_user_setting;
    $array_data_user_setting["friend_list"] = json_encode($array_friend_list);
    $array_data_user_setting["id_user"] = $id_user;
    $array_data_user_setting["username"] = $username;

    $UserSetting->save($array_data_user_setting);

}
/*end function update_friend_list($id_user, $id_user_friend) */

$array_friend = null;

/*doc thong tin friend*/
$this->loadModel("Friend");
$array_friend = $this->Friend->read($uid_friend);
if ($array_friend == null) exit("invalid_friend");

/*lay id_user cua người gửi*/
$id_friend = $array_friend["id"];
$id_user_send_request = $array_friend["id_user"];
$username_send_request = $array_friend["username"];

/*luu du lieu vao bang friends*/
$array_friend_update = NULL;
$array_friend_update["id"] = $id_friend;
$array_friend_update["status"] = "1";
$this->Friend->save($array_friend_update);

/*lưu dữ liệu vào bảng user_settings*/
$this->loadModel("UserSetting");

$id_user_accept= $this->CurrentUser->id;
$username_accept = $this->CurrentUser->username;

/*goi ham update_friend_list de update cho cả người gửi và người nhận*/
update_friend_list($id_user_accept, $username_accept, $id_user_send_request, $this->UserSetting);
update_friend_list($id_user_send_request, $username_send_request, $id_user_accept, $this->UserSetting);

/*lưu dữ liệu vào bảng friends*/
echo "accepted";

?>