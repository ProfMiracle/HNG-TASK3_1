<?php
require_once "db.php";///////database connection
require_once "functions.php";///////all functions

if ($_SERVER['REQUEST_METHOD']=='POST') {

////////////adding a test to reset ///////////////	
	if (isset($_POST['sid'])=='demosid' && isset($_POST['authToken'])=='demoauth') {
       
        if (!isset($_POST['response_method'])) {
              $response=array(
                                    'error' => 207,
                                    "error_message" =>"Response method cannot be empty"
                                  );
          }else{
                $response=array(
                                  'status' => 3,
                                  'status_message' =>'Request method updated successfully'
                  );
  }
}
/////////////////////////////////////////////////////

  if (isset($_POST['sid'])) {
		$id=filter($_POST["sid"]);
	}
	if (isset($_POST['authToken'])) {
		$auth=filter($_POST["authToken"]);
	}
	if (isset($_POST['response_method'])) {
		$response_met=$_POST["response_method"];
	}


  
		
		
		$min = 1;
		$max = 2;
		

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
        elseif(empty($response_met) OR $response_met==""){
              $response=array(
                                    'error' => 207,
                                    "error_message" =>"Response method cannot be empty"
                                  );
        }elseif (empty($result)) {
        	$response=array(
                                    'error' => 204,
                                    "error_message" =>"You Don't have an account with us"
                                  );
        }elseif (filter_var($response_met, FILTER_VALIDATE_INT, array("options" => array("min_range"=>$min, "max_range"=>$max))) === false) {
			    $response=array(
                                    'error' => 208,
                                    "error_message" =>"Invalid reponse value"
                                  );
		}
        else{

        	/////////update unit balance///////////////////////////
                  $stmt = $con->prepare("UPDATE user SET response_method = ? WHERE AccountID = ? and AuthToken = ?");
                  $stmt->bind_param("iss",$response_met, $id, $auth);
                  $stmt->execute();
                  $stmt->close();
                  /////////////////////////////////////////////////////
                
		$response=array(
				'status' => 3,
				'status_message' =>'Request method updated successfully'
			);
	}

	//$response = $_POST;

}else{
  header("HTTP/1.1 403 FORBIDEN");
}

response($response, $response_method);
?>