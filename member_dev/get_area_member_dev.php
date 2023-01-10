<?php

$area_str_code = "";
if(isset($_GET["area"])) $area_str_code = $_GET["area"];
/*token list*/
$array_data = NULL;
$token_list = $this->Token->get(array("data" => "area", "action" =>"get_parent", "params"=>$area_str_code));
$array_data["token_action"] = $token_list;	
if(isset($_GET["debug"])) $array_data["debug_api" ] = "true";

/*send & get data return*/
$this->loadLib("Api");	
$str_data =  $this->Api->send($array_data);	
if($str_data == "") exit("no_data");
$array_area_result = json_decode($str_data, true);


if(!isset($array_area_result["data"])) exit("error: no_data");
$array_areas = $array_area_result["data"];

/*data area to selectbox*/
$Html = $this->load("Html");
$Html->load("Form");


$str_selectbox_area = "";
if($array_areas )foreach($array_areas as $row) $str_selectbox_area .= $Html->Form->selectbox(array("onchange" =>"change_area(this.value)", "class" => "select_area"), $row["area"], $row["selected"]);

echo $str_selectbox_area;

?>