<?php
header("Content-Type:application/json");

////////////credentials
$mysid = "ACcd44f65db5f8ed31060c7f852b82c0db";///////my sid
$mytoken = "909e0cec1316ea243f56a44e540e2622";///////my token
$Twiliophone = "+12029338352"; ///////paste twilio phone
/////////////////
require_once 'Twilio/autoload.php';
use Twilio\Rest\Client;

$phone = $_GET['phone'];
$messagen = $_GET['message'];

if (isset($phone) && $phone !="" && isset($messagen) && $messagen !="") {
 
$sid    = $mysid;
$token  = $mytoken;

function filter($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function validate_phone($number)
{
     // Allow +, - and . in phone number
     $filtered_phone = filter_var($number, FILTER_SANITIZE_NUMBER_INT);
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

$newmessage = filter($messagen);////////get message from the string
$to = validate_phone($phone);/////phone forward message to

$twilio = new Client($sid, $token);

$message = $twilio->messages
                  ->create("+2348153193630", // to
                           [
                               "body" => $newmessage,
                               "from" => $Twiliophone
                           ]
                  );

//print($message->sid);

}elseif ($_GET['phone']=="" OR $_GET['message']=="") {
	echo "phone or mesage can't be empty";
}else{
	echo "an error occured contact admin";
}
?>