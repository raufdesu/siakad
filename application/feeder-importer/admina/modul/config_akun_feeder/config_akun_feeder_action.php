<?php
session_start();
include "../../inc/config.php";
session_check();
switch ($_GET["act"]) {
  case "in":
  
  
  
  $data = array("username"=>$_POST["username"],"password"=>$_POST["password"],"url"=>$_POST["url"],"port"=>$_POST["port"],"id_sp"=>$_POST["id_sp"],);
  
  
  
   if(isset($_POST["live"])=="on")
    {
      $live = array("live"=>"Y");
      $data=array_merge($data,$live);
    } else { 
      $live = array("live"=>"N");
      $data=array_merge($data,$live);
    }
    $in = $db->insert("config_user",$data);
    
    if ($in=true) {
      echo "good";
    } else {
      return false;
    }
    break;
  case "delete":
    
    
    
    $db->delete("config_user","id",$_GET["id"]);
    break;
  case "up":
   $data = array("username"=>$_POST["username"],"password"=>$_POST["password"],"url"=>$_POST["url"],"port"=>$_POST["port"],"id_sp"=>$_POST["id_sp"],);
   
   
   

    if(isset($_POST["live"])=="on")
    {
      $live = array("live"=>"Y");
      $data=array_merge($data,$live);
    } else { 
      $live = array("live"=>"N");
      $data=array_merge($data,$live);
    }
    $up = $db->update("config_user",$data,"id",$_POST["id"]);
    if ($up=true) {
      echo "good";
    } else {
      return false; 
    }
    break;
  default:
    # code...
    break;
}

?>