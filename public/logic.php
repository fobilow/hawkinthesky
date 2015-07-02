<?php

include_once '../vendor/autoload.php';
include_once 'inc.php';

if(isset($_GET['action']))
{
  $action = $_GET['action'];
  $id = (int)$_GET['id'];
  switch($action)
  {
    case 'enable':
      Hawk::dbConn()->executeSql("UPDATE websites SET disabled=0 WHERE ga_property_id=".$id);
      break;
    case 'disable':
      Hawk::dbConn()->executeSql("UPDATE websites SET disabled=1 WHERE ga_property_id=".$id);
      break;
  }

  header('Location: /configure.php');
}


?>
