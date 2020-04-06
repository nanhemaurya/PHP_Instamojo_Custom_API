<?php
include_once 'constants.php';
include_once 'Methods.php';
//header('Content-Type: application/json');


$api = new api();
$result = array();
$server = $_SERVER['REQUEST_METHOD'];

if (in_array($server, array("GET", "POST", "DELETE"))) {
    if ($server == "POST") {
        $payload_params = array();
        $payload_params_key = array();
        foreach ($_POST as $key => $value) {
            $payload_params[$key] = $value;
            $payload_params_key[] = $key;
        }
        $mandatoryInput = array(
            "purpose",
            "amount",
            "phone",
            "buyer_name",
            "redirect_url",
            "send_email",
            "send_sms",
            "email",
            "allow_repeated_payments"
        );

        //if (in_array($payload_params_key, $mandatoryInput)) {
        $result = $api->createPaymentRequest($payload_params);
//        } else {
//            $errRes = array(
//                "message"=> "Incomplete Information"
//            );
//            $result = $api->responseError($errRes);
//        }

        echo ($result);
    }
}

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
?>



<html>
    <head>

    </head>
    <body>

        <form method="POST" enctype="multipart/form-data">

            <input type="text" name="purpose" value="Whisky" />
            <input type="number" name="amount" value="657" />
            <input type="number" name="phone" value="9910217048" />
            <input type="text" name="buyer_name" value="SNMBoy" />
            <input type="text" name="redirect_url" value="http://localhost/instamojo/response.php" />
            <input type="text" name="send_email" value="false" />
            <input type="text" name="send_sms" value="false" />
            <input type="text" name="email" value="foo@example.com" />
            <input type="text" name="allow_repeated_payments" value="false" />


            <input type="submit" value="ghjhjg" />
        </form>

    </body>
</html>