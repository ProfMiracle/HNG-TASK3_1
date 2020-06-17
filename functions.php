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
          $authAdmin = $result[0]['auth'];
          $Adminsid = $result[0]['sid'];
          $TwilioPhone = $result[0]['phone_number'];
          //////////////////////


function selectFromUser($id='$id', $auth='$auth'){
          global $con;

          $stmt = $con->prepare("SELECT * FROM user WHERE AccountID = ? and AuthToken = ?");
          $stmt->bind_param("ss", $id, $auth);
          $stmt->execute();
          $result = $stmt->GET_result()->fetch_all(MYSQLI_ASSOC);
          $stmt->close();
          return $result;
}

////////funtions///////////
function filter($data) {///////this function is used to validate input
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


/*function getBalance($id, $key){
        
        selectFromUser();

          $email = $result[0]['email'];
          $balance = $result[0]['unit'];
          $feed = array('
                  email'=>$email, 
                  'balance'=>$balance
                );
        ///////////
        return $feed;
}*/

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


function checkFraud($id, $auth, $messagen, $phone, $balance){

        if ($auth=="" OR empty($auth)) {
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
        elseif(empty($messagen) OR $messagen==""){
              $response=array(
                                    'error' => 203,
                                    "error_message" =>"No test in request. check to confirm"
                                  );
        }
        elseif(empty($phone) OR $phone==""){
              $response=array(
                                    'error' => 206,
                                    "error_message" =>"No phone number provided"
                                  ); 
        }
        else{

          //////////MAKE SURE MESSAGE IS ONE PAGE////////////
          $count_message = strlen($messagen);
          ///////////////////////////////////////////////////

          //////////INSIST ON NOT MORE THAN 2 PAGES PER SMS////////////////
          if ($count_message>=161) {
            $page=1;
          }
          elseif ($count_message>=321) {
            $page=2;
          }
          else{
            $page=0;
          }
          /////////////////////////////////////////////////////////////////


          ////////////Check Unit Balance//////////////////////////////////

          //////////////Check if User exist///////////////////////
          $result=selectFromUser($id, $auth);
          ////////////////////////////////////////////////////////

          if(empty($result)) 
            {
              $response=array(
                                'error' => 204,
                                'error_message' =>'You dont have an account with us.'
                              );

            }
          if ($balance<$page) 
            {
              $response=array(
                                'error' => 205,
                                'error_message' =>'You dont have any units in your account.'
                              );
            }
          
        }
        if (isset($response)) {
          return $response;
        }
        
        }

function array_to_xml($array, &$xml) {        
    foreach($array as $key => $value) {               
        if(is_array($value)) {            
            if(!is_numeric($key)){
                $subnode = $xml->addChild($key);
                array_to_xml($value, $subnode);
            } else {
                array_to_xml($value, $subnode);
            }
        } else {
            $xml->addChild($key, $value);
        }
    }        
}


function response($response, $response_method='1'){
  if ($response_method==2) {

  $xml = new SimpleXMLElement('<Projects/>'); 
  array_to_xml($response, $xml);
  
  header('Content-Type: application/xml');
  // TO PRETTY PRINT OUTPUT
$domxml = new DOMDocument('1.0');
$domxml->preserveWhiteSpace = false;
$domxml->formatOutput = true;
$domxml->loadXML($xml->asXML());

echo $domxml->saveXML();

  }else{
     header('Content-Type: application/json');
            echo json_encode($response);
  }

}
//////////////////////////


?>