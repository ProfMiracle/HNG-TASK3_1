<?php
require_once "db.php";///////database connection
require_once "functions.php";///////all functions
require_once 'Twilio/autoload.php';/////////load Twilio

use Twilio\Rest\Client;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  $accesvia = "GET";
}else{
  $accesvia = "";
}
  //$accesvia==$_SERVER["REQUEST_METHOD"];///////how its being accessed

  switch($accesvia)
  {
    case 'GET':

      /////GET email
      if(!empty($_GET))/////////make sure GET query holds value
      {
       ///////////////////////filter data
        $id = filter($_GET['id']);
        $key = filter($_GET['key']);
        $phone = '+'.$_GET['phone'];
        $messagen = $_GET['message'];
       //////////////////////////////

        ////////////Check Unit Balance
        ///GET balance from data base////////////////
          $stmt = $con->prepare("SELECT * FROM user WHERE sid = ? and api_key = ?");
          $stmt->bind_param("ss", $id, $key);
          $stmt->execute();
          $result = $stmt->GET_result()->fetch_all(MYSQLI_ASSOC);
          if(empty($result)) {
            $response=array(
                'status' => 419,
                'status_message' =>'You dont have an account with us.'
              );
          }
          $stmt->close();
          $email = $result[0]['email'];
          $balance = $result[0]['unit'];
          $user_id = $result[0]['id'];
          //////////////////////

          if ($balance<1) {
            $response=array(
                'status' => 420,
                'status_message' =>'You dont have any units in your account.'
              );
          }else{

      $newmessage = filter($messagen);////////GET message from the string
      $to = validate_phone($phone);/////phone forward message to
 
      $twilio = new Client($sid, $auth);

      $message = $twilio->messages
                  ->create($phone, // to
                           [
                               "body" => $newmessage,
                               "from" => $TwilioPhone
                           ]
                  );
      }
                  ////////////response coding
      if(!empty($message->sid)){

        /////////update unit balance
          $stmt = $con->prepare("UPDATE user SET unit = unit-1 WHERE sid = ? and api_key = ?");
          $stmt->bind_param("ss", $id, $key);
          $stmt->execute();
          $stmt->close();
          //////////////////


          /////////update history
            $stmt = $con->prepare("INSERT INTO history (user_id, to_, message) VALUES (?,?,?)");
            $stmt->bind_param("sss", $user_id, $phone, $newmessage);
            $stmt->execute();
            $stmt->close();
          //////////////////

        $response=array(
                'status' => 1,
                'status_message' =>'Message Sent Successfully.'
              );
            }
            else
            {
              $response=array(
                'status' => 0,
                'status_message' =>'Message sending Failed.'
              );
            }
  header('Content-Type: application/json');
  echo json_encode($response);

}
      
      break;
    
    default:
      // Invalid Request Method
      header("HTTP/1.0 405 Method Not Allowed");
      break;
  }
?>