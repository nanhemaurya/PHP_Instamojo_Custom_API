<?php

include_once '../../config/core.php';
header('Content-Type: application/json');

$api = new api();
$user = new user();
$result = array();
$server = $_SERVER['REQUEST_METHOD'];

if (in_array($server, array("POST"))) {
    if ($server == "POST") {
        $payload_params = array();
        //    $payload_params_key = array();
        foreach ($_POST as $key => $value) {
            $payload_params[$key] = $value;
        }

        $userId = filter_input(INPUT_POST, "user_id");

        if (!empty($payload_params)) {
            if ($user->isUserExist($userId)) {
                $ress = $api->createPaymentRequest($payload_params);
                if ($ress != "null") {
                    if ($user->updatePaymentRequest($userId, json_encode($ress))) {
                        $Res = array(
                            "message" => "Payment Initiated",
                            "response" => array(
                                "payment_initiated" => TRUE,
                                "payment_gateway_response" => json_decode($ress)
                            )
                        );

                        $result = $api->responseSuccess($Res);
                        
                        //$result = json_decode($ress);
                    } else {
                        $Res = array(
                            "message" => "Could not initiate the request",
                            "response" => array(
                                "payment_initiated" => FALSE
                            )
                        );
                        $result = $api->responseError($Res);
                    }
                } else {
                    $Res = array(
                        "message" => "Payment Gateway Technical Error",
                        "response" => array(
                                "payment_initiated" => FALSE
                            )
                    );
                    $result = $api->responseError($Res);
                }
            } else {
                $Res = array(
                    "message" => "Invalid Credential",
                    "response" => array(
                        "payment_initiated" => FALSE
                    )
                );
                $result = $api->responseError($Res);
            }
        } else {
            $Res = array(
                "message" => "Incomplete Request"
            );
            $result = $api->responseError($Res);
//        }
        }
    } else {
        $Res = array(
            "message" => "Invalid Request Method"
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


//$payload = Array(
//    'purpose' => 'Testing Purpose',
//    'amount' => '10',
//    'phone' => '9910217048',
//    'buyer_name' => 'John Doe',
//    'redirect_url' => 'http://localhost/instamojo/response.php',
//    'send_email' => false,
//    //'webhook' => 'http://www.example.com/webhook/',
//    'send_sms' => false,
//    'email' => 'foo@example.com',
//    'allow_repeated_payments' => false
//);
//
//print_r($payload);
//print_r("<br><br>");
//function paymentRequest($payload) {
//    $ch = curl_init();
//    curl_setopt($ch, CURLOPT_URL, 'https://test.instamojo.com/api/1.1/payment-requests/');
//    curl_setopt($ch, CURLOPT_HEADER, FALSE);
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
//    curl_setopt($ch, CURLOPT_HTTPHEADER, Constants::$CURLOPT_HTTPHEADER);
////$payload = Array(
////    'purpose' => 'Testing Purpose',
////    'amount' => '10',
////    'phone' => '9910217048',
////    'buyer_name' => 'John Doe',
////    'redirect_url' => 'http://localhost/instamojo/response.php',
////    'send_email' => false,
////    //'webhook' => 'http://www.example.com/webhook/',
////    'send_sms' => false,
////    'email' => 'foo@example.com',
////    'allow_repeated_payments' => false
////);
//    curl_setopt($ch, CURLOPT_POST, true);
//    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
//    $response = curl_exec($ch);
//    curl_close($ch);
//    $resArr = json_decode($response, TRUE);
//    return json_encode($resArr, JSON_PRETTY_PRINT);
//}
//}
