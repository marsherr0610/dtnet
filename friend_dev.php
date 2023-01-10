<?php 
 class friend extends Controller
 {
  function index() {
    if(isset($_GET["action"]) && ($_GET["action"]=="request")) return $this->run("send");
    if(isset($_GET["action"]) && ($_GET["action"]=="accept")) return $this->run("accept");
    if(isset($_GET["action"]) && ($_GET["action"]=="cancel")) return $this->run("cancel");


   echo $this->render("index");
  }
  
  /* END: function all */
 }
 /* END:  class member extends Controller */
?>