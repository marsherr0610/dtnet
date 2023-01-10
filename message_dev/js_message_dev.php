<script>
  	var array_message =  {};
	var end_uid;
	var start_uid;

/*HÃ m tráº£ vá» 1 dÃ²ng báº¡n bÃ¨*/
function load_friend_item(friend)
{
		//console.log(friend);
    /*láº¥y Ä‘Æ°á»ng dáº«n tá»›i profile*/    
    //if(friend.profile) link_image = file_url + friend.profile;
    //else 
    link_image = template_url + "images/pages/profile/profile.png";

    str_active = "";
    if(friend.status == "1") str_active = " active";
	
    /*hÃ¬nh profile*/
    str_profile =   "<div class = 'message_friend_profile'><img src ='" + link_image + "'/></div>";
    
    friend_name = friend.user_fullname;
    last_message = "";
    time = "09:00";
    uid_friend = friend.uid_user_friend;
    /*TÃªn báº¡n, ná»™i dung chat cuá»‘i cÃ¹ng, ngÃ y giá» chat*/
    str_name = "<div class = 'message_friend_name"+ str_active +"'>" + friend_name + "</div>";
    str_msg  = "<div class = 'message_friend_msg"+ str_active +"'>" + last_message + "</div>"; 
    str_time = "<div class = 'message_friend_time'>" + time + "</div>"; 
    
    str_name_msg_time =     "<div class = 'message_friend_name_msg_time'>" + str_name + str_msg + str_time + "</div>"; 
    
    console.log(str_name);
    /*Tráº£ vá» dÃ²ng html má»™t ngÆ°á»i báº¡n*/
    return "<a href = 'javascript:void(0)' onclick = 'show_chat(\"" + uid_friend +"\")'><div class = 'message_friend_item'>" + str_profile + str_name_msg_time +  "</div></a>";
}
/*end: function load_friend_item()*/

/*hÃ m láº¥y thÃ´ng tin*/
function check_friend_info(friend_item)
{
	if(!friend_item.hasOwnProperty("fullname")) friend_item.fullname = "";
	if(!friend_item.hasOwnProperty("profile")) friend_item.profile = "";
	if(!friend_item.hasOwnProperty("uid")) friend_item.uid = "";
	if(!friend_item.hasOwnProperty("last_message")) friend_item.last_message = "";
	if(!friend_item.hasOwnProperty("time")) friend_item.time = "";
	if(!friend_item.hasOwnProperty("status")) friend_item.status = "";
	return 	friend_item;
}
/*end: function get_friend_info()*/

	var array_friend;
	function get_friend()
	{
		array_friend = [];
		
    /*get friend list*/
    document.getElementById("message_friend_items").innerHTML =  "Loading...";
    var url_message = "<?php echo $this->get_link(array("controller" => "message", "function" => "index")); ?>";
    $.ajax({url: url_message, data: {action: "get_friend"}, success: function(result){

      try {
        /*phan tich result thanh Json*/
        var array_friend = JSON.parse(result);
        
        console.log(array_friend);
        //show_friend();

        str_friend_item = "";
    if(array_friend)
    {

        var profile = "";
        for (i = 0; i<array_friend.length; i++) str_friend_item += load_friend_item(check_friend_info(array_friend[i]));
      
        
    }
    /*end: if(array_friend)*/
    
    document.getElementById("message_friend_items").innerHTML += str_friend_item;
      } catch (error) {
        document.getElementById("message_friend_items").innerHTML =  "Error: "+error+"</br>"+result;
      }
    }});
    /*END: Ajax*/
	}
	/*end: function get_friend()*/

/*HÃ m hiá»ƒn thá»‹ vÃ  tÃ¬m kiáº¿m danh sÃ¡ch báº¡n bÃ¨*/
function show_friend()
{
    str_friend_item = "";
    /*Náº¿u máº£ng array_friend cÃ³ dá»¯ liá»‡u*/
    
    console.log(array_friend);
    if(array_friend)
    {

        var profile = "";
        for (i = 0; i<array_friend.length; i++) str_friend_item += load_friend_item(check_friend_info(array_friend[i]));
      
        
    }
    /*end: if(array_friend)*/
    
    document.getElementById("message_friend_items").innerHTML += str_friend_item;
}
/*end: function show_friend()*/

var uid_friend = "";
function show_chat(uid_friend_chat)
{
  uid_friend = uid_friend_chat;
	/*get friend info*/
	if(friend_profile != "") url_friend_img_profile =  file_url + friend_profile;
	else url_friend_img_profile = template_url + "images/pages/profile/profile.png";	

	document.getElementById("message_chat").style.display = "";
	document.getElementById("message_friend").style.display = "none";
	get_message("new");

}
/*end: function show_chat(uid_friend)*/


function get_message_items(obj, type_request)
{
	
    if(!obj || obj.length==0) return "";
    
	var str_result = "";    
	for (i in obj)
	{
		/*Kiá»ƒm tra tin nháº¯n nÃ y Ä‘Ã£ Ä‘Æ°á»£c láº¥y vá» chÆ°a, náº¿u chÆ°a thÃ¬ lÆ°u vÃ o máº£ng array_message*/
		if(!array_message.hasOwnProperty(obj[i].uid))
		{
			/*lÆ°u vÃ o máº£ng array_message*/
			array_message[obj[i].uid] = obj[i].uid;
			 
			/*táº¡o dÃ²ng html tin nháº¯n*/
			 
			/*láº¥y ngÃ y giá» gá»­i vÃ o biáº¿n str_status*/
			created_date = new Date(obj[i].created);
			str_status = created_date.getHours()+":"+created_date.getMinutes()+ " ";
			str_status += created_date.getDate()+"-"+(created_date.getMonth()+1) + '- ' + created_date.getFullYear();
				
			/*Láº¥y thÃ´ng tin dÃ²ng chat*/
			/*Náº¿u type = 1 thÃ¬ Ä‘Ã¢y lÃ  tin gá»­i Ä‘i, náº±m bÃªn trÃ¡i*/
			if(obj[i].type == "1") str_item = get_item_sent(obj[i].content, str_status, obj[i].uid);
			else str_item = get_item_receive(obj[i].content, obj[i].uid, str_status);

			/*ÄÆ°a dÃ²ng chat vÃ o biáº¿n str_message, káº¿t quáº£ tá»« server tráº£ vá» má»›i trÆ°á»›c cÅ© sau => xáº¿p tin nháº¯n tá»« dÆ°á»›i lÃªn*/
			str_result = str_item + str_result;
		}
		/*end: if(array_message.hasOwnProperty(obj[i].uid)*/
	}
	/*end: for (i in obj)*/
	
	/*cáº­p nháº­t end_uid, start_uid Ä‘á»ƒ xÃ¡c Ä‘á»‹nh vá»‹ trÃ­ tin má»›i vÃ  tin cÅ©*/
			
	/*Náº¿u yÃªu cáº§u lÃ  láº¥y tin nháº¯n má»›i, thÃ¬ end_uid lÃ  uid cá»§a tin nháº¯n Ä‘áº§u tiÃªn */
	if(type_request == 'new')
	{
		end_uid = obj[0].uid;
		
		/*náº¿u chÆ°a cÃ³ start_uid thÃ¬ start_uid  báº±ng uid cá»§a pháº§n tá»­ Ä‘áº§u tiÃªn*/
		if(start_uid == "") start_uid = obj[obj.length -1 ].uid;
	}

	/*Náº¿u yÃªu cáº§u lÃ  láº¥y tin nháº¯n cÅ©, thÃ¬ start_uid lÃ  uid cá»§a tin nháº¯n cÅ© cuá»‘i cÃ¹ng(xáº¿p tá»« má»›i Ä‘áº¿n cÅ©) trong cÃ¡c tin cÅ© */
	if(type_request == 'old') start_uid = obj[obj.length -1 ].uid;

	return str_result;
				
	
}
/*end: function get_message_items()*/

function show_message_items(message_items, type_request)
{
	if(message_items == "") return;
	
	var msg_frame_obj = document.getElementById("msg_frame");
	
	/*náº¿u Ä‘Ã¢y lÃ  yÃªu cáº§u láº¥y tin nháº¯n má»›i thÃ¬ Ä‘Æ°a vÃ o phÃ­a dÆ°á»›i, náº¿u yÃªu cáº§u láº¥y tin nháº¯n cÅ© thÃ¬ Ä‘Æ°a vÃ o phÃ­a trÃªn*/
	if(type_request == "new")
	{
		/*ÄÆ°a xuá»‘ng dÆ°á»›i*/
		document.getElementById("msg_content").innerHTML += message_items;
		
		/*Cuá»™n tháº» div msg_frame_obj xuá»‘ng dÆ°á»›i cÃ¹ng*/
		msg_frame_obj.scrollTop = msg_frame_obj.scrollHeight;

		return;
	}
	/*end: if(type_request == "new")*/
	
	
	/*ÄÆ°a vÃ o phÃ­a trÃªn*/
	document.getElementById("msg_content").innerHTML = message_items + document.getElementById("msg_content").innerHTML;
		
	/*Cuá»™n tháº» div msg_frame_obj lÃªn trÃªn cÃ¹ng*/
	msg_frame_obj.scrollTop = 0;

}
/*end: function show_message_items(message_items)*/


/*HÃ m láº¥y dá»¯ liá»‡u chat vá»›i báº¡n Ä‘ang chá»n, type_request = new: láº¥y dá»¯ liá»‡u má»›i, type_request = old: láº¥y dá»¯ liá»‡u cÅ©*/
function get_message(type_request)
{

  /*lay du lieu message*/
  
  document.getElementById("msg_content").innerHTML =  "Loading...";
  var url_message = "<?php echo $this->get_link(array("controller" => "message", "function" => "index")); ?>";
    $.ajax({url: url_message, data: {action: "get", friend: uid_friend}, success: function(result){
      document.getElementById("msg_content").innerHTML =  result;
    }});
  return;
  
	var array_message_data = [];
	array_message_data[0] = { "uid": "11111", "created": "2015-03-25 07:30:25","content" : "hello","type" : "1"};
	array_message_data[1] = { "uid": "2222", "created": "2015-03-25 07:30:25","content" : "xin chao", "type": "2"};
	array_message_data[2] = { "uid": "3333", "created": "2015-03-25 07:30:25","content" : "hiii hii", "type": "2"};
	array_message_data[3] = { "uid": "44444", "created": "2015-03-25 07:30:25","content" : "ok","type" : "1"};

	var str_message_items = get_message_items(array_message_data, type_request);

	show_message_items(str_message_items, type_request);	
	return;
	
    /*láº¥y dá»¯ liá»‡u Ä‘Ã£ chat vá»›i báº¡n*/
    url_msg_get_message = url_msg + "?act=get&uid_user_friend=" + document.getElementById("uid_user_friend").value;
    url_msg_get_message += "&type="+ type_request;
    url_msg_get_message += "&start="+ start_uid;
    url_msg_get_message += "&end="+ end_uid;

    /*console.log(url_msg_get_message);*/
    
    $.ajax({
            type: "GET",
            url: url_msg_get_message,
            success: function(str_data)
            {
                /*phÃ¢n tÃ­ch chuá»—i json str_data Ä‘á»ƒ táº¡o thÃ nh chuá»—i tin nháº¯n*/
                str_message = parse_message(str_data, type_request );
                
                if(str_message == "") return;
                
                
                /*náº¿u Ä‘Ã¢y lÃ  yÃªu cáº§u láº¥y tin nháº¯n má»›i thÃ¬ Ä‘Æ°a vÃ o phÃ­a dÆ°á»›i, náº¿u yÃªu cáº§u láº¥y tin nháº¯n cÅ© thÃ¬ Ä‘Æ°a vÃ o phÃ­a trÃªn*/
                if(type_request == "new")
                {
                    /*ÄÆ°a xuá»‘ng dÆ°á»›i*/
                    document.getElementById("msg_content").innerHTML += str_message;
                    
                    /*Cuá»™n tháº» div msg_frame_obj xuá»‘ng dÆ°á»›i cÃ¹ng*/
                    msg_frame_obj.scrollTop = msg_frame_obj.scrollHeight;
    
                }/*end: if(type_request == "new")*/
                else
                {
                    /*ÄÆ°a vÃ o phÃ­a trÃªn*/
                    document.getElementById("msg_content").innerHTML = str_message + document.getElementById("msg_content").innerHTML;
                    
                    /*Cuá»™n tháº» div msg_frame_obj lÃªn trÃªn cÃ¹ng*/
                    msg_frame_obj.scrollTop = 0;
    
                }
                /*end: else if(type_request == "new")*/

                /*Gá»i hÃ m náº¡p láº¡i danh sÃ¡ch báº¡n bÃ¨*/
                //get_friend();
            }
    });
}
/*end: function get_message()*/


function close_chat()
{
	document.getElementById("message_chat").style.display = "none";
	document.getElementById("message_friend").style.display = "";
}

/*HÃ m táº¡o chuá»—i HTML má»™t dÃ²ng chat Ä‘Ã£ gá»­i*/
function get_item_sent(content, str_status, str_uid)
{
   /*Táº¡o chuá»—i chá»©a ná»™i dung*/
    str_content = "<p class= 'msg_item_chat' id='msg_content_"+ str_uid +"'>"+ content +"</p>";
    
    /*Táº¡o chuá»—i chá»©a tráº¡ng thÃ¡i*/  
    str_status = "<span id='msg_status_"+ str_uid +"'>" +str_status+ "</span>";

    /*Táº¡o tháº» div chá»©a ná»™i dung vÃ  tráº¡ng thÃ¡i*/
    str_item = " <div class= 'msg_item_content right'>"+str_content + str_status+"</div>";
    return "<div class = 'msg_item' id='msg_item_"+ str_uid +"'>" + str_item + "</div>";
}
/*end: function get_item_sent(content, status, str_uid)*/

/*HÃ m táº¡o chuá»—i HTML má»™t dÃ²ng chat nháº­n Ä‘Æ°á»£c tá»« báº¡n bÃ¨*/
var friend_profile = "";
var url_friend_img_profile = "";

function get_item_receive(content,  str_uid_chat_receive, status)
{

	
    /*Táº¡o chuá»—i chá»©a hÃ¬nh Ä‘áº¡i diá»‡n*/
    str_img = " <div class = 'msg_item_img'> <img src= '"+ url_friend_img_profile +"'></div>";
 
    str_status = "<span>"+status+"</span>";
    str_content = "<p>"+ content +"</p>";

   /*Táº¡o chuá»—i chá»©a ná»™i dung*/
    str_content_item = "<div class='msg_item_chat_left' id='msg_content_"+ str_uid_chat_receive +"'>"+str_content+str_status + "</div>";
    
  
    /*Táº¡o tháº» div chá»©a ná»™i dung vÃ  tráº¡ng thÃ¡i*/
    str_left_item = " <div class= 'msg_item_content left'>"+str_img + str_content_item+"</div>";
    return "<div class = 'msg_item' id='msg_item_"+ str_uid_chat_receive +"'>" + str_left_item + "</div>";
}
/*end: function get_item_sent(content,  str_uid_chat_receive, status)*/

	
/*HÃ m dÃ¹ng Ä‘á»ƒ Ä‘Æ°a tin nháº¯n ngÆ°á»i dÃ¹ng nháº­p vÃ o khung ná»™i dung vÃ  Ä‘Æ°a dá»¯ liá»‡u lÃªn server*/
function send_message()
{
    /*Láº¥y ná»™i dung ngÆ°á»i dÃ¹ng nháº­p*/
    msg= $("textarea").val();    

    /*Náº¿u cÃ³ ná»™i dung vÃ  ngÆ°á»i nháº­n thÃ¬ gá»­i ná»™i dung*/
    if(msg != '')
    {   
        /*Láº¥y ná»™i dung cá»§a ngÆ°á»i dÃ¹ng vá»«a nháº­p*/
        chat_content = $("textarea").val();

        /*Táº¡o chuá»—i id ngáº«u nhiÃªn vÃ  duy nháº¥t*/
        sent_uid = create_UUID();

        /*Táº¡o html ná»™i dung dÃ²ng chat bÃªn trÃ¡i*/
        str_chat_content = chat_content.replace(/</g, "&lt;");
        str_chat_content = str_chat_content.replace(/>/g, "&gt;");

        str_send_item = get_item_sent(str_chat_content, "Äang gá»­i", sent_uid);
      

        /*ChÃ¨n ná»™i dung chat vÃ o tháº» div cÃ³ id="msg_content"*/
        document.getElementById("msg_content").innerHTML += str_send_item;

        /*Cuá»™n tháº» div msg_content xuá»‘ng dÆ°á»›i cÃ¹ng*/
		var msg_frame_obj = document.getElementById("msg_frame");
        msg_frame_obj.scrollTop = msg_frame_obj.scrollHeight;

        /*XÃ³a ná»™i dung trong Ã´ chat sau khi ngÆ°á»i dÃ¹ng nháº¥n nÃºt gá»­i*/
        $("textarea").val("");

        /*Gá»­i dá»¯ liá»‡u lÃªn server Ä‘á»ƒ lÆ°u*/
        //send_msg(chat_content, uid_user_friend, sent_uid);

        //get_friend();
        return;

    } 
    /*if(msg != '')*/
}
/*end: function send()*/



/*HÃ m táº¡o chuá»—i uid ngáº«u nhiÃªn*/
function create_UUID()
{
    var dt = new Date().getTime();
    var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = (dt + Math.random()*16)%16 | 0;
        dt = Math.floor(dt/16);
        return (c=='x' ? r :(r&0x3|0x8)).toString(16);
    });
    return uuid;
}
/*end: function create_UUID()*/
</script>