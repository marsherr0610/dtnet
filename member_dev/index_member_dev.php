<?php 
$Html = $this->load("Html");

$url_friend= $this->get_link(array("controller" => "friend", "function" => "index"));
  $link_friend = $Html->link(array("href" => $url_friend, "class" => "button info"), "Friends");

  $url_friend_sent= $this->get_link(array("controller" => "friend", "function" => "index", "get" => "action=sent"));
  $link_friend_sent = $Html->link(array("href" => $url_friend_sent, "class" => "button info"), "Đã Gửi Kết Bạn");


  $url_friend_receive= $this->get_link(array("controller" => "friend", "function" => "index", "get" => "action=receive"));
  $link_friend_receive = $Html->link(array("href" => $url_friend_receive, "class" => "button info"), "Yêu Cầu Kết Bạn");

  echo $link_friend;
  echo $link_friend_sent;
  echo $link_friend_receive;



echo $Html->heading("Danh sách thành viên");

/* Search khu vực*/
$Html->load("Form");
$div_area = $Html->div("", "id = 'div_area' style = 'float: left; width: 100%'");
$hidden_area = $Html->Form->hidden(array("name"=>"data[area]", "id" => "area_str_code", "value" => $area_str_code));
echo "Khu vuc: ".$div_area.$hidden_area;

$this->loadLib("Api");
$array_friend_list = null;
/*lay danh sach friend_list tu bang user_settings*/
$array_param_api_user_setting = NULL;
$array_param_api_user_setting["token_action"] = $this->MyString->jwt(array("data" =>"setting","action" =>"get"));
$array_param_api_user_setting["token_user"] = $this->CurrentUser->token_user;
$array_user_setting = $this->Api->send($array_param_api_user_setting, true);
if($array_user_setting != null ) $array_friend_list = json_decode($array_user_setting["friend_list"], true);

/*request post_cat from api*/	
$array_api_user = NULL;
$array_api_user["token_action"] = $this->MyString->jwt(array("data" =>"member","action" =>"list"));
$array_user = $this->Api->send($array_api_user, true);
if ($array_user != null) {
 foreach ($array_user as $row)
 {

  $id_user = $row['id'];
  $uid_user = $row['uid'];
  $fullname = $row["fullname"];
  $email = $row["email"];

  if($fullname == "") $fullname = $email;

  if(isset($array_friend_list[$id_user]["status"]) ) $status_friend = $array_friend_list[$id_user]["status"];
  
  
  /*check user hien tai da co tron friend_list chua*/
  $url_request_friend = $this->get_link(array("controller" => "friend", "function" => "index"));
  $str_status_friend = $Html->link(array("href" => "javascript:void(0)", "class" => "button info", "onclick"=>"send('$uid_user')"), "Kết bạn");

  if ($status_friend == "1") {
    $str_status_friend = "Bạn bè";
    $str_status_friend .= $Html->link(array("href" => "javascript:void(0)", "class" => "button info", "onclick"=>"cancel_friend('$uid_user')"), "Hủy kết bạn");
  }
  if ($status_friend == "2")
  {
    $str_status_friend = "Đã gửi kết bạn";
    $str_status_friend .= $Html->link(array("href" => "javascript:void(0)", "class" => "button info", "onclick"=>"cancel_request('$uid_user')"), "Thu hồi");
  } 
  if ($status_friend == "3") 
  {
    $str_status_friend = "Muốn kết bạn";
    $str_status_friend .= $Html->link(array("href" => "javascript:void(0)", "class" => "button info", "onclick"=>"accept('$uid_user')"), "Đồng ý");
    $str_status_friend .= $Html->link(array("href" => "javascript:void(0)", "class" => "button info", "onclick"=>"cancel_receive('$uid_user')"), "Không kết bạn");

  }


  $url_profile = $this->get_link(array("controller" => "member", "function" => "index", "get" => "member=$uid_user"));
  $link_member = $Html->link(array("href" => $url_profile, "class" => "button"), $fullname);

  $url_message = $this->get_link(array("controller" => "message", "function" => "index", "get" => "member=$uid_user"));
  $link_message = $Html->link(array("href" => $url_message, "class" => "button info"), "Nhắn tin");

  $str_status = $Html->span($link_request_friend, "id=member_$uid_user");
  echo "<div class ='member' > $link_member $link_message $str_status_friend  </div>";
 }
 /*END: foreach ($array_user as $row) */
}
// $array_post_cat =  $this->Api->send($array_data, true)

$array_lang = null;
$array_lang["tiengviet"]["friend"]["sent_ok"] = "Đã gửi kết bạn";
$array_lang["english"]["friend"]["sent_ok"] = "Friend requested";

$area_str_code = "vietnam";
?>

<script>

  var current_lang = "tiengviet";
  var array_lang_friend = <?php echo json_encode($array_lang);?>;
  function send(uid_friend){
    
    /*goi ham ajax de ket ban*/
    var url_request = "<?php echo $url_request_friend; ?>";
    $.ajax({url: url_request, data: {action: "request", member: uid_friend}, success: function(result){
      
      try {
        /*phan tich result thanh Json*/
        var obj_result = JSON.parse(result);
        var msg = obj_result["msg"];
        if(obj_result['result'] == "ok")  document.getElementById("member_"+ uid_friend).innerHTML = array_lang_friend[current_lang]["friend"][msg];
        else document.getElementById("member_"+ uid_friend).innerHTML =  "Error: "+msg;

      } catch (error) {
        document.getElementById("member_"+ uid_friend).innerHTML =  "Error: "+error+"</br>"+result;
      }

    }});
  }
  /*end: function send(uid_friend)*/

  function accept(uid_friend){
    /*goi ham ajax de chap nhan */
    var url_receive = "<?php echo $url_request_friend; ?>";
    $.ajax({url: url_receive, data: {action: "receive", member: uid_friend}, success: function(result){
      alert (result);
      document.getElementById("member_"+ uid_friend).innerHTML =  "Chấp nhận";
    }});
  }
  /*end: function accept(uid_friend)*/

  function show_area_input(str_code)
	{
		/*begin : Lấy danh sách địa danh*/
		var url_area = "<?php echo $this->get_link(array("controller" =>"member", "function" => "index", "get" =>"action=get_area")); ?>";
		if(url_area.indexOf("?") === -1) url_area += "?";
		url_area +=  "&area=" + str_code;		

		
		$.ajax({  method: "GET",  url: url_area,  data: {  } }).done(function( result ) 
		{
			document.getElementById("div_area").innerHTML = result;
			
			document.getElementById("area_str_code").value = str_code;
			
			/*autocomplete các input*/
			$( ".select_area" ).autocomplete({reset: true});
			
			list_street();
			
		});
		/*end : Lấy danh sách địa danh*/
	}
	/* end:function show_area() */


  var area_str_code = "<?php echo $area_str_code; ?>";

	/*init*/
	$(document).ready(function()
	{

		show_area_input(area_str_code);

	});
	/*end : $(document).ready(function()*/

  function change_area (str_code)
	{
		show_area_input(str_code);
		
	}

 
</script>
