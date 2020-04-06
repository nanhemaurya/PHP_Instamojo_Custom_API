<?php

include_once '../../config/core.php';
header('Content-Type: application/json');

$api = new api();
$user = new user();
$result = array();
//$payment_id = $_GET["payment_id"];
//$payment_status = $_GET["payment_status"];
//$payment_request_id = $_GET["payment_request_id"];
$userId = filter_input(INPUT_GET, "user_id");
$payment_id = filter_input(INPUT_GET, "payment_id");
$payment_status = filter_input(INPUT_GET, "payment_status");
$payment_request_id = filter_input(INPUT_GET, "payment_request_id");

//$server = $_SERVER['REQUEST_METHOD'];
$server = filter_input(INPUT_SERVER, "REQUEST_METHOD");

if (in_array($server, array("GET"))) {
    if (isset($payment_id) and isset($payment_status) and isset($payment_request_id) and isset($userId)) {
        $payment_response = array(
            "payment_id" => $payment_id,
            "status" => $payment_status,
            "payment_request_id" => $payment_request_id
        );
        $Res = array(
            "payment_response" => $payment_response
        );
        $user->updatePaymentResponseAndStatus($userId, json_encode($payment_response));
        if ($payment_status == "Credit") {
            $user->updateIsSignUpPayementDone($userId, "true");
        }else{
			$user->updateIsSignUpPayementDone($userId, "false");
		}
        $result = $api->responseSuccess($Res);
    } else {
        $Res = array(
            "message" => "Incomplete Request"
        );
        $result = $api->responseError($Res);
    }
} else {
    $Res = array(
        "message" => "Invalid Request"
    );
    $result = $api->responseError($Res);
}
echo json_encode($result, JSON_PRETTY_PRINT);







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


