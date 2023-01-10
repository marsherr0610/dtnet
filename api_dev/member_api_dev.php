<?php 
 $this->loadModel("User");
 $this->User->fields = "id, uid, username, fullname, email, phone";
 $array_user = $this->User->get();
 echo json_encode($array_user);

?>