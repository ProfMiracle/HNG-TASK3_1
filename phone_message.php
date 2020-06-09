<?php
require_once "db.php";///////database connection
require_once "functions.php";///////all functions
require_once 'Twilio/autoload.php';/////////load Twilio

use Twilio\Rest\Client;

  $accesvia=$_SERVER["REQUEST_METHOD"];///////how its being accessed

  switch($request_method)
  {
    case 'POST':

      /////Post email
      if(!empty($_POST))/////////make sure post query holds value
      {
       ///////////////////////filter data
        $id = filter($_POST['id']);
        $key = filter($_POST['key']);
        $phone = $_POST['phone'];
        $messagen = $_POST['message'];
       //////////////////////////////

        ////////////Check Unit Balance
        ///get balance from data base////////////////
          $stmt = $con->prepare("SELECT * FROM user WHERE sid = ? and api_key = ?");
          $stmt->bind_param("s", $id);
          $stmt->bind_param("s", $key);
          $stmt->execute();
          $result = $stmt->get_result()()->fetch_all(MYSQLI_ASSOC);
          if($result->num_rows < 1) {
            $response=array(
                'status' => 419,
                'status_message' =>'You dont have an account with us.'
              );
          }
          $stmt->close();
          $email = $result[0]['email'];
          $balance = $result[0]['unit'];
          //////////////////////

          if ($balance<1) {
            $response=array(
                'status' => 420,
                'status_message' =>'You dont have any units in your account.'
              );
          }else{

      $newmessage = filter($messagen);////////get message from the string
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
                  ////////////reponse coding
      if(!empty($message->sid)){

        /////////update unit balance
          $stmt = $con->prepare("UPDATE user SET unit = ? WHERE sid = ? and api_key = ?");
          $stmt->bind_param("ss", $id, $key);
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