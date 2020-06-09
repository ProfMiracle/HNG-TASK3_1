<?php
require_once "db.php";///////database connection
require_once "functions.php";///////all functions

  $accesvia=$_SERVER["REQUEST_METHOD"];///////how its being accessed

  switch($accesvia)
  {
    case 'GET':
      ///Retrieve balance
      if(!empty($_GET["id"]) && $_GET['id']!="" && !empty($_GET['key']) && $_GET['key']!="")/////////make sure get query holds value
      {
        
          ///////////////////////filter data
        $id = filter($_GET['id']);
        $key = filter($_GET['key']);
        //////////////////////////////
        getBalance($id, $key);

      }
      
      break;
    
    default:
      // Invalid Request Method
      header("HTTP/1.0 405 Method Not Allowed");
      break;
  }

?>