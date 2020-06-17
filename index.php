<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>sms</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="assets/css/Article-Clean.css">
    <link rel="stylesheet" href="assets/css/Data-Table.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <div class="article-clean">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-xl-8 offset-lg-1 offset-xl-2">
                    <div class="intro">
                        <h1 class="text-center">SIMPLE SMS NOTIFIER MICROSERVICE USING TWILIO</h1>
                        <p class="text-center"><span class="by">by</span> <a href="#">#TEAM_TITAN</a><span class="date">JUNE 8th, 2020</span></p><img class="img-fluid" src="assets/img/desk.jpg"></div>
                    <div class="text">
                        <p>SMS Notifier micro-service. For registration, kindly contact the admin at backend.teamlead@teamtitans.hngi7</p>
                        <h2>Demo details</h2>
                        <p>sid = demosid and authToken = demoauth</p>
                        <h2>Configure Response format</h2>
                        <p>Below is a sample PHP code using POST</p>
                        <p style="font-family: 'Cutive Mono', monospace;background-color: #f0f0f0;padding-left: 10px;padding-right: 10px;padding-top: 2px;padding-bottom: 2px;white-space: nowrap;overflow-x: scroll;">//extract data from the post<br><br>extract($_POST);<br><br>//set POST variables<br><br>$url = 'http://[WEBSITE URL]/v1/configure';<br><br>$query=array(<br><br> 'sid' =&gt;'',<br><br> 'authToken' =&gt; '',<br><br> 'response_method'
                            =&gt;'',<br><br>);<br><br>//url-ify the data for the POST<br><br>$built_query = http_build_query($query);<br><br>//open connection<br><br>$ch = curl_init();<br><br>//set the url, number of POST vars, POST data<br><br>curl_setopt($ch,CURLOPT_URL,
                            $url);<br><br>curl_setopt($ch,CURLOPT_POST, true);<br><br>curl_setopt($ch,CURLOPT_POSTFIELDS, $built_query);<br><br>//execute post<br><br>$result = curl_exec($ch);<br><br>//close connection<br><br>curl_close($ch);<br><br>$response=json_decode($result,
                            true);<br><br>echo $response;<br></p>
                        <h2>Send SMS</h2>
                        <figure></figure>
                        <p>This process uses a POST METHOD request. Below is a sample POST request with PHP<br></p>
                        <p style="font-family: 'Cutive Mono', monospace;background-color: #f0f0f0;padding-left: 10px;padding-right: 10px;padding-top: 2px;padding-bottom: 2px;white-space: nowrap;overflow-x: scroll;">//extract data from the post<br><br>extract($_POST);<br><br>//set POST variables<br><br>$url = 'http://[WEBSITE URL]/v1/sendsms';<br><br>$query=array(<br><br> 'sid' =&gt;'',<br><br> 'authToken' =&gt; '',<br><br> 'phone' =&gt;'',<br><br>                            'message' =&gt;'',<br><br>);<br><br>//url-ify the data for the POST<br><br>$built_query = http_build_query($query);<br><br>//open connection<br><br>$ch = curl_init();<br><br>//set the url, number of POST vars, POST data<br><br>curl_setopt($ch,CURLOPT_URL,
                            $url);<br><br>curl_setopt($ch,CURLOPT_POST, true);<br><br>curl_setopt($ch,CURLOPT_POSTFIELDS, $built_query);<br><br>//execute post<br><br>$result = curl_exec($ch);<br><br>//close connection<br><br>curl_close($ch);<br><br>$response=json_decode($result,
                            true);<br><br>echo $response;<br></p>
                        <h2>Check Balance</h2>
                        <p>This process uses POST request. Below is a sample POST request with PHP<br></p>
                        <p style="font-family: 'Cutive Mono', monospace;background-color: #f0f0f0;padding-left: 10px;padding-right: 10px;padding-top: 2px;padding-bottom: 2px;white-space: nowrap;overflow-x: scroll;">//extract data from the post<br><br>extract($_POST);<br><br>//set POST variables<br><br>$url = 'http://[WEBSITE URL]/v1/balance';<br><br>$query=array(<br><br> 'sid' =&gt;'',<br><br> 'authToken' =&gt; '',<br><br>);<br><br>//url-ify
                            the data for the POST<br><br>$built_query = http_build_query($query);<br><br>//open connection<br><br>$ch = curl_init();<br><br>//set the url, number of POST vars, POST data<br><br>curl_setopt($ch,CURLOPT_URL, $url);<br><br>curl_setopt($ch,CURLOPT_POST,
                            true);<br><br>curl_setopt($ch,CURLOPT_POSTFIELDS, $built_query);<br><br>//execute post<br><br>$result = curl_exec($ch);<br><br>//close connection<br><br>curl_close($ch);<br><br>$response=json_decode($result, true);<br><br>echo
                            $response;<br><br>//////////////////////////////////////////////////////////<br></p>
                    </div>
                    <h2>Parameter Definition</h2><table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Parameter</th>
                <th>Allowed value</th>
                <th>Use</th>
                
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>sid</td>
                <td>string</td>
                <td>Unique Company ID provided after registration</td>
                
            </tr>
            <tr>
                <td>authToken</td>
                <td>string</td>
                <td>Unique company Authentication Token Provided after Registration</td>
            </tr>
            <tr>
                <td>response_method</td>
                <td>Integer</td>
                <td>Preffered Data reponse format: 1 for JSON or 2 for XML</td>
            </tr>
            <tr>
                <td>phone</td>
                <td>Number</td>
                <td>Message Destination Phone number</td>
            </tr>
            <tr>
                <td>message</td>
                <td>String</td>
                <td>Message to be sent</td>
                
            </tr>
            
            
        </tbody>
    </table>
                    <h2>Return codes and meaning</h2><table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Code</th>
                <th>Reason</th>
                <th>Explanation</th>
                
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>201</td>
                <td>Error</td>
                <td>Data sent is missing an authentication token</td>
                
            </tr>
            <tr>
                <td>202</td>
                <td>Error</td>
                <td>Data sent is missing an account id (SID)</td>
            </tr>
            <tr>
                <td>203</td>
                <td>Error</td>
                <td>Message you are trying to send don't have a text(character) in it</td>
            </tr>
            <tr>
                <td>204</td>
                <td>Error</td>
                <td>You dont have an account with us</td>
            </tr>
            <tr>
                <td>205</td>
                <td>Error</td>
                <td>You are low on credit, Please top up to continue sending messages</td>
                
            </tr>
            <tr>
                <td>206</td>
                <td>Error</td>
                <td>Message request sent is missing a destination phone number</td>
                
            </tr>
            <tr>
                <td>207</td>
                <td>Error</td>
                <td>Preffered response method must have a value</td>
            </tr>
            <tr>
                <td>208</td>
                <td>Error</td>
                <td>Resnponse method should be intergers 2 or 1 only</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Status</td>
                <td>Message sent successfully</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Status</td>
                <td>Message sending failed</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Status</td>
                <td>Request method updated successfully</td>
            </tr>
            
        </tbody>
    </table><footer id="footer">
    
    <div style= "background: black; text-align: center; margin: 0px; padding:10px">
        <p style= "color:grey; font-family: raleway">Copyright (c) 2020 #team_titan HNGi7</p>
    </div>
</footer></div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
</body>

</html>