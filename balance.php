<?php

require_once "db.php";///////database connection
require_once "functions.php";///////all functions

  
      if($_SERVER['REQUEST_METHOD']=="POST")/////////make sure POST query holds value
      {
        
          ////////////adding a test to balance ///////////////  
          if (isset($_POST['sid'])=='demosid' && isset($_POST['authToken'])=='demoauth') {
            
              $bal = mt_rand(111, 999);

            $response = array(
                                        'email'=>'demo@xyz.com', 
                                        'balance'=>$bal
                                  );
          }
            /////////////////////////////////////////////////////


          ///////////////////////filter data
          if (isset($_POST['sid'])) {
            $id=filter($_POST["sid"]);
          }
          if (isset($_POST['authToken'])) {
            $auth=filter($_POST["authToken"]);
          }
        //////////////////////////////

        /////////////////////////////////////
        //$result=selectFromUser();
          $stmt = $con->prepare("SELECT * FROM user WHERE AccountID = ? and AuthToken = ?");
          $stmt->bind_param("ss", $id, $auth);
          $stmt->execute();
          $result = $stmt->GET_result()->fetch_all(MYSQLI_ASSOC);
          $stmt->close();

          if (!empty($result)) {
            $response_method = $result[0]['response_method'];
          }else{
            $response_method =1;
          }
            

            if ($auth=="" || empty($auth)) {
                  $response=array(
                                        'error' => 201,
                                        "error_message" =>"Auth Token cannot be empty."
                                      );
            }

            elseif ($id=="" OR empty($id)) {
                  $response=array(
                                        'error' => 202,
                                        "error_message" =>"Account ID cannot be empty"
                                      );
            }
            
            elseif (empty($result)) {
              $response=array(
                                        'error' => 204,
                                        "error_message" =>"You Don't have an account with us"
                                      );
            }
            else{


                $email = $result[0]['email'];
                $balance = $result[0]['unit'];
                  $response = array(
                                        'email'=>$email, 
                                        'balance'=>$balance
                                  );
          }

      }else{    
        header("HTTP/1.0 405 Method Not Allowed");
      }
      
      if (isset($response)) {
        response($response, $response_method);
      }
      
?>