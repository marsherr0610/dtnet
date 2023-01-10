<?php 
 class member extends Controller
 {
  function index() {
   if(isset($_GET["action"]) && ($_GET["action"] == "get_area")) return $this->run("get_area");
   echo $this->render("index");
  }

  
  /* END: function all */
 }
 /* END:  class member extends Controller */
?>