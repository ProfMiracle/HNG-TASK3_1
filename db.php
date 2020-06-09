<?php 
mysqli_report(MYSQLI_REPORT_ERROR| MYSQLI_REPORT_STRICT);

$servername = "localhost";
$username = "root";
$password = "";
$database = "team_titan";

$con = new mysqli($servername, $username, $password, $database);
if($con->connect_error) {
  exit('Something really weird just happened'); 
}
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$con->set_charset("utf8mb4");
?>
