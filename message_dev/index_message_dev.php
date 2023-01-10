<link rel="stylesheet" href="<?php echo $this->template_url; ?>css/pages/message.css">
<div id="message">

    <!-- Begin: Phần bên trái danh sách bạn bè và tin nhắn cuối cùng -->
    <div id ="message_friend">
        <div id = 'message_friend_search'>
            <input type="text" id="input_search_friend" />  
        </div>
        <div id = 'message_friend_items' class="col100">
            
            
        </div>
    </div>
    <!-- End: Phần bên trái danh sách bạn bè và tin nhắn cuối cùng -->
	
   <!--BEGIN: PHẦN BÊN PHẢI-->
    <div id ="message_chat" style = "display:none">
        
        <!-- BEGIN: Header chat -->
        <div id="friend_info">
            <?php
    
                /*Lấy thông tin của người đang được chọn*/
                $link_image = $this->template_url."images/pages/profile/profile.png";
            ?>
            <div class = "friend_img">
                <img class="img_info" src="<?php echo $link_image; ?>" />
            </div>
            
			  <div class="friend_name">
                <h3></h3>
                <p> <!-- Hoạt động 5 phút trước --></p>

				    <button type = "button" id = "chat_close" onclick = "close_chat()">X</button>

            </div>
			
			
			
        </div>
        <!-- END: Header chat -->
    
    
        <!-- Begin: Nội dung tin nhắn -->
        <div id="msg_frame" onclick="get_message('new')">
            <div id ="msg_content" onclick="get_message('new')">
    
            </div>
        
        </div>
        <!-- End: Nội dung tin nhắn -->    
        
        <!--BEGIN: input and send message-->
        <div id="message_input">
            <textarea name="V2data[content]" id = "chat_content" maxlength="1500"></textarea>    
            <button type="button" id = "send_button" onclick = "send_message()">Gửi</button>
            <input type="hidden" name = "V2data[uid_user_friend]" value=""  id = "uid_user_friend" />
        </div>    
        <!--END: PHẦN NHẬP NỘI DUNG-->
        
    </div>
     <!--END: PHẦN BÊN PHẢI-->
	 
	
</div>
<link rel="stylesheet" href="<?php echo $this->template_url;?>css/pages/message.css">

<?php  $this->run("js"); ?>
<script>
	get_friend();
</script>