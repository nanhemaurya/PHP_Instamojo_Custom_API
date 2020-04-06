<?php

include_once '../../config/core.php';

header('Content-Type: application/json');



$api = new api();
$user = new user();
$result = array();
$server = $_SERVER['REQUEST_METHOD'];

if (in_array($server, array("POST"))) {
    if ($server == "POST") {
        $required_field = array();
        $user_id = filter_input(INPUT_POST, "unique_id");
        $token = filter_input(INPUT_POST, "token");


        if (empty($user_id)) {
            $required_field[] = "unique_id";
        }
        if (empty($token)) {
            $required_field[] = "token";
        }


        if (!empty($user_id) and ! empty($token)) {
            if ($user->loginByToken($user_id, $token)) {    
                $Res = array(
                    "login" => "success",
                    "user_details" => $user->getUserDetailByToken($user_id, $token),
                    "is_signup_payment_done" => $user->getIsSignUpPayementDone($user_id));
                $result = $api->responseSuccess($Res);
            } else {
                $Res = array(
                    "login" => "failed",
                    "message" => "Expired Credential");
                $result = $api->responseError($Res);
            }
        } else {
            $Res = array(
                "message" => "Incomplete Information",
            );
            if (!empty($required_field)) {
                $Res["missing_field"] = $required_field;
            }

            $result = $api->responseError($Res);
        }
    } else {
        $Res = array(
            "message" => "Invalid Request Type"
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
