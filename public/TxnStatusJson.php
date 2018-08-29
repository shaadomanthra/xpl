<?php header("Pragma: no-cache"); 
header("Cache-Control: no-cache"); 
header("Expires: 0");  
// following files need to be included 
require_once("./lib/config_paytm.php"); 
require_once("./lib/encdec_paytm.php");  

$ORDER_ID = $_GET['orderid']; 
$requestParamList = array(); 
$responseParamList = array();  
$requestParamList = array("MID" => PAYTM_MERCHANT_MID , "ORDERID" => $ORDER_ID);   
$checkSum = getChecksumFromArray($requestParamList,PAYTM_MERCHANT_KEY); 
$requestParamList['CHECKSUMHASH'] = urlencode($checkSum);  
$data_string = "Request <br>".json_encode($requestParamList,JSON_PRETTY_PRINT)."<br><br>"; 
echo $data_string;  
$ch = curl_init(); // initiate curl 
$url = PAYTM_STATUS_QUERY_URL; //Paytm server where you want to post data  
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
curl_setopt($ch, CURLOPT_URL,$url); 
curl_setopt($ch, CURLOPT_POST, true); // tell curl you want to post something 
curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string); // define what you want to post 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the output in string format 
$headers = array(); $headers[] = 'Content-Type: application/json'; 

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
$output = curl_exec($ch); // execute 
$info = curl_getinfo($ch);  
$data = json_decode($output, true); 
echo "Response<br><pre>"; 
print_r($output); 
echo "</pre>"; ?>