<?php

include_once 'constants.php';
include_once 'Methods.php';
header('Content-Type: application/json');


$api = new api();

$payment_id = $_GET["payment_id"];
$payment_status = $_GET["payment_status"];
$payment_request_id = $_GET["payment_request_id"];

$res = array(
    "success" => "true",
    "payment_response" => array(
        "payment_id" => $payment_id,
        "status" => $payment_status,
        "payment_request_id" => $payment_request_id,
    )
);


//echo $api->getPaymentRequestDetails($payment_request_id);


echo json_encode($res, JSON_PRETTY_PRINT);




//echo "payment_id payment_status payment_request_id";


//$ch = curl_init();

//curl_setopt($ch, CURLOPT_URL, "https://www.instamojo.com/api/1.1/payment-requests/$payment_request_id/");
//curl_setopt($ch, CURLOPT_HEADER, FALSE);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
//curl_setopt($ch, CURLOPT_HTTPHEADER,
//            array("X-Api-Key:d82016f839e13cd0a79afc0ef5b288b3",
//                  "X-Auth-Token:3827881f669c11e8dad8a023fd1108c2"));
//$response = curl_exec($ch);
//curl_close($ch); 

//echo $response;


