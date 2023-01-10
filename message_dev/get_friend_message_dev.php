<?php

/*request friend from api*/	
$this->loadLib("Api");
$array_api_friend = NULL;
$array_api_friend["token_action"] = $this->Token->get(array("data" =>"friend","action" =>"list"));
$array_api_friend["token_user"]=$this->CurrentUser->token_user;

echo $this->Api->send($array_api_friend);
return;



/*lay id cua current user*/
$uid_user_current = $this->CurrentUser->uid;

if ($array_friend != null)
{
  foreach ($array_friend as $row)
  {   
        /*xac dinh current user la user hay la user_friend*/
        $uid_user_friend = $row["uid_user_friend"];
        $uid_user = $row["uid_user"];
        if($uid_user_current == $uid_user) $column = "user_fullname_friend";  
        else $column = "user_fullname";

        $fullname = $row[$column];
        echo "<div class='friend'>$fullname </div>";

  }
}

?>