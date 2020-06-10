<?php

/////message details/////////
$stmt = $con->prepare("SELECT * FROM admin WHERE status = '1'");
          //$stmt->bind_param("i", '1');
          $stmt->execute();
          $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
          if(empty($result)) {
            die("you don't have an active service, please contact eMiracle");
          }
          $stmt->close();
          $auth = $result[0]['auth'];
          $sid = $result[0]['sid'];
          $TwilioPhone = $result[0]['phone_number'];
          //////////////////////

////////funtions///////////
function filter($data) {///////this function is used to validate input
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


function getBalance($id, $key){
        global $con;
        ///get balance from data base////////////////
          $stmt = $con->prepare("SELECT * FROM user WHERE sid = ? and api_key = ?");
          $stmt->bind_param("ss", $id, $key);
          $stmt->execute();
          $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
          if(empty($result)) {
            die('you have no record with us, contact eMiracle');
          }
          $stmt->close();
          $email = $result[0]['email'];
          $balance = $result[0]['unit'];

          $feed = array('email'=>$email, 'balance'=>$balance);
        ///////////
        header('Content-Type: application/json');
        echo json_encode($feed);
}

function validate_phone($number)
{
  $numb='+'.$number;
     // Allow +, - and . in phone number
     $filtered_phone = filter_var($numb, FILTER_SANITIZE_NUMBER_INT);
     // Remove "-" from number

     $phone_to_check = str_replace("-", "", $filtered_phone);
     // Check the lenght of number

     // This can be customized if you want phone number from a specific country
     if (strlen($phone_to_check) < 11 || strlen($phone_to_check) > 14) {
        return false;
     } else {
       return true;
     }
}


//////////////////////////


?>