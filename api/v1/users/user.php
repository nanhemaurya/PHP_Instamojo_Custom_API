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
        $password = filter_input(INPUT_POST, "password");


        if (empty($user_id)) {
            $required_field[] = "Email, username or user id ";
        }
        if (empty($password)) {
            $required_field[] = "password";
        }


        if (!empty($user_id) and ! empty($password)) {

            $password = md5($password);

            if ($user->isUserExistforLogin($user_id, $password)) {
                $Res = array(
                    "fetch_detail" => "success",
                    "user_detail" => $user->getUserDetail($user_id, $password),
                    "is_signup_payment_done" => $user->getIsSignUpPayementDone($user_id));
                $result = $api->responseSuccess($Res);
            } else {
                $Res = array(
                    "fetch_detail" => "failed",
                    "message" => "Invalid Credential");
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
