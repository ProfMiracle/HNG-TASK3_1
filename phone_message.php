<?php
/////////header functions
//header("Access-Control-Allow-Methods: POST");
//header("Access-Control-Max-Age: 3600");
//header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
///////////////////////////

require_once "db.php";///////database connection
require_once "functions.php";///////all functions
require_once 'Twilio/autoload.php';/////////load Twilio

use Twilio\Rest\Client;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $accesvia = "POST";
}else{
  $accesvia = "";
}

////////////adding a test to phone_message ///////////////  
          if (isset($_POST['sid'])=='demosid' && isset($_POST['authToken'])=='demoauth') {

              if (!isset($_POST['phone'])) {
              $response=array(
                                    'error' => 206,
                                    "error_message" =>"No phone number provided"
                                  ); 
              }elseif (!isset($_POST['message'])) {
              $response=array(
                                    'error' => 203,
                                    "error_message" =>"No test in request. check to confirm"
                                  );
              }else{
                  $response=array(
                          'status' => 1,
                          'status_message' =>'Message Sent Successfully.'
                        );
          }
        }
/////////////////////////////////////////////////////



//$accesvia==$_SERVER["REQUEST_METHOD"];///////how its being accessed

switch($accesvia)
  
  {
    case 'POST':

          ///////////DECLARE VARIABLES////////
          if (isset($_POST['sid'])) {
           $id = filter($_POST['sid']);
          }

          if (isset($_POST['authToken'])) {
           $auth = filter($_POST['authToken']);
          }

          if (isset($_POST['phone'])) {
          $phone = '+'.$_POST['phone'];
          }

          if (isset($_POST['message'])) {
          $messagen = $_POST['message'];
          }
          
          
          
          ////////////////////////////////////

          

          /////////////////CONTINUE VARIABLE DECLARE/////////////
              $stmt = $con->prepare("SELECT * FROM user WHERE AccountID = ? and AuthToken = ?");
              $stmt->bind_param("ss", $id, $auth);
              $stmt->execute();
              $result = $stmt->GET_result()->fetch_all(MYSQLI_ASSOC);
              $stmt->close();

              $email = $result[0]['email'];
              $balance = $result[0]['unit'];
              $user_id = $result[0]['id'];
              $response_method = $result[0]['response_method'];
          //////////////////////////////////////////////////////

              ///////////ERROR CHECKER//////////////////
          $response=checkFraud($id, $auth, $messagen,$phone, $balance);
          ///////////////////////////////////////////

      if(empty($response))/////////make sure POST query is good to go
        {     
              ////////POST message from the string
              $newmessage = filter($messagen);
              ////////////////////////////////////

              /////phone forward message to///////////
              $to = validate_phone($phone);
              ////////////////////////////////////////
         
              /////////TWILIO INSTANCE//////////////////////
              $twilio = new Client($Adminsid, $authAdmin);
              //////////////////////////////////////////////

              ///////////MESSAGE SEND///////////////////////
              $message = $twilio->messages
                                          ->create('+'.$phone, // to
                                                     [
                                                         "body" => $newmessage,
                                                         "from" => $TwilioPhone
                                                      ]
                                                  );
              ////////////////////////////////////////////////


              ////////////response coding///////////////////////////////
              if(!empty($message->sid))
                {

                  /////////update unit balance///////////////////////////
                  $stmt = $con->prepare("UPDATE user SET unit = unit-1 WHERE AccountID = ? and AuthToken = ?");
                  $stmt->bind_param("ss", $id, $auth);
                  $stmt->execute();
                  $stmt->close();
                  /////////////////////////////////////////////////////


                  /////////update history//////////////////////////////////
                    $status = 'sent';

                    $stmt = $con->prepare("INSERT INTO history (user_id, to_, message, status) VALUES (?,?,?,?)");
                    $stmt->bind_param("ssss", $user_id, $phone, $newmessage,$status);
                    $stmt->execute();
                    $stmt->close();
                  /////////////////////////////////////////////////////

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

            }

            ///////////RESPONSE//////////////
           response($response);
      

      break;
default:
      // Invalid Request Method
      header("HTTP/1.0 405 Method Not Allowed");
      break;
  }
?>