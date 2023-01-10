<?php
class message extends Controller
{
	function index()
	{
    if(isset($_GET["action"]) && ($_GET["action"] == "get")) return $this->run("get");
    if(isset($_GET["action"]) && ($_GET["action"] == "send")) return $this->run("send");
    if(isset($_GET["action"]) && ($_GET["action"] == "get_friend")) return $this->run("get_friend");

    echo $this->render("index");
	}
	/*end:function index*/
 
} 
/*end: class place extends Main*/
?>