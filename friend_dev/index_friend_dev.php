<?php 

$action = "";
if(isset($_GET["action"])) $action = $_GET["action"];


$Html = $this->load("Html");

$title = "Danh Sách Bạn Bè";

if($action == "sent") $title = "Đã Gửi Kết Bạn"; 
if($action == "receive") $title = "Yêu Cầu Kết Bạn"; 

echo $Html->heading($title);

/*request friend from api*/	
$this->loadLib("Api");
$array_api_friend = NULL;
$array_api_friend["token_action"] = $this->MyString->jwt(array("data" =>"friend","action" =>"list", "params" => $action));
$array_api_friend["token_user"]=$this->CurrentUser->token_user;

// $str_data = $this->Api->send($array_api_friend);

$array_friend = $this->Api->send($array_api_friend, true);
$column = "user_fullname_friend";

$link_cancel = "";
$link_accept = "";



$uid_user_current = $this->CurrentUser->uid;
if ($array_friend != null)
{
  foreach ($array_friend as $row) {
    $id = $row["id"];
    $uid_friend = $row["uid"];
    if($action == "receive") {
      $column = "user_fullname";
      $url_friend_cancel= $this->get_link(array("controller" => "friend", "function" => "index", "get" => "action=cancel&friend=$uid_friend"));
      $link_cancel = $Html->link(array("href" => $url_friend_cancel, "class" => "button info"), "Hủy");

      $url_friend_accept= $this->get_link(array("controller" => "friend", "function" => "index", "get" => "action=accept&friend=$uid_friend"));
      $link_accept = $Html->link(array("href" => $url_friend_accept, "class" => "button info"), "Chấp Nhận");
    }
    if($action == "sent") {
      $url_friend_cancel= $this->get_link(array("controller" => "friend", "function" => "index", "get" => "action=cancel&friend=$uid_friend"));
      $link_cancel = $Html->link(array("href" => $url_friend_cancel, "class" => "button info"), "Hủy");
    
    }

    /*xac dinh current user la user hay la user_friend*/
    $uid_user_friend = $row["uid_user_friend"];
    $uid_user = $row["uid_user"];
    if($uid_user_current == $uid_user) $column = "user_fullname_friend";  
    else $column = "user_fullname";

   
    $fullname = $row[$column];
    echo "<div class='friend'>$fullname $link_cancel $link_accept $id </div>";

  }
}
?>
