<?php
$xml = "<?xml version='1.0'?>
<root>
  <rows>
    <col1>Code</col1>
    <col2>Reason</col2>
    <col3>Explanation</col3>
  </rows>
  <rows>
    <col1>201</col1>
    <col2>Error</col2>
    <col3>Data sent is missing an authentication token</col3>
  </rows>
  <rows>
    <col1>202</col1>
    <col2>Error</col2>
    <col3>Data sent is missing an account id (SID)</col3>
  </rows>
  <rows>
    <col1>203</col1>
    <col2>Error</col2>
    <col3>Message you are trying to send don't have a text(character) in it</col3>
  </rows>
  <rows>
    <col1>204</col1>
    <col2>Error</col2>
    <col3>You dont have an account with us</col3>
  </rows>
  <rows>
    <col1>205</col1>
    <col2>Error</col2>
    <col3>You are low on credit Please top up to continue sending messages</col3>
  </rows>
  <rows>
    <col1>206</col1>
    <col2>Error</col2>
    <col3>Message request sent is missing a destination phone number</col3>
  </rows>
  <rows>
    <col1>207</col1>
    <col2>Error</col2>
    <col3>Preffered response method must have a value</col3>
  </rows>
  <rows>
    <col1>208</col1>
    <col2>Error</col2>
    <col3>Resnponse method should be intergers 2 or 1 only</col3>
  </rows>
  <rows>
    <col1>1</col1>
    <col2>Status</col2>
    <col3>Message sent successfully</col3>
  </rows>
  <rows>
    <col1>2</col1>
    <col2>Status</col2>
    <col3>Message sending failed</col3>
  </rows>
  <rows>
    <col1>3</col1>
    <col2>Status</col2>
    <col3>Request method updated successfully</col3>
  </rows>
</root>";

//Convert the XML string into an SimpleXMLElement object.
$xmlObject = simplexml_load_string($xml);
 
//Encode the SimpleXMLElement object into a JSON string.
$jsonString = json_encode($xmlObject);
 
//Convert it back into an associative array for
//the purposes of testing.
$jsonArray = json_decode($jsonString, true);
 
//var_dump out the $jsonArray, just so we can
//see what the end result looks like
header('Content-Type: application/json');
echo json_encode($jsonArray);

?>