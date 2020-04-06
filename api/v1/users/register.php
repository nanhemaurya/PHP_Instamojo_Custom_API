<?php

include_once '../../config/core.php';

header('Content-Type: application/json');

//echo $user_id = time().rand(1000, 9999);


$api = new api();
$user = new user();
$result = array();
$server = $_SERVER['REQUEST_METHOD'];

if (in_array($server, array("POST"))) {
    if ($server == "POST") {
        $validationRes = array();
        $required_field = array();
        $validation = FALSE;
        //$user_id = filter_input(INPUT_POST, "user_id");
        $email = filter_input(INPUT_POST, "email");
        $fullname = filter_input(INPUT_POST, "fullname");
        $password = filter_input(INPUT_POST, "password");

        $user_id = time().rand(100, 999);

        //$user_id = trim($_POST["user_id"]);
        //$fullname = $_POST["fullname"];
        //$email = $_POST["email"];
        //$password = $_POST["password"];


        if (empty($user_id)) {
            $required_field[] = "user_id";
        }
        if (empty($email)) {
            $required_field[] = "email";
        }
        if (empty($fullname)) {
            $required_field[] = "fullname";
        }
        if (empty($password)) {
            $required_field[] = "password";
        }

        $genUsername = explode("@", $email);
        $username = $genUsername[0];

        if (!empty($user_id) and ! empty($fullname) and ! empty($email) and ! empty($password)) {
            $user_id = trim($user_id);
            $password = md5($password);
            $fullname = trim($fullname);


            if (preg_match("/^[0-9]*$/", $user_id)) {
                
            } else {
                $validationRes["user_id"] = "Invalid UserId";
            }


            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $validationRes["email"] = "Invalid Email";
            }

            if (preg_match("/[a-zA-Z][a-zA-Z ]+[a-zA-Z]$/", $fullname) and $user->validStrLen($fullname, 3, 64)) {
                $fullname = trim(preg_replace('/\s+/',' ', $fullname));
            } else {
                $validationRes["fullname"] = "Invalid Full Name";
            }

//            if (!ereg('/^[0-9]*$/gm', $user_id)) {
//                $validationRes["user_id"] = "Invalid UserId";
//            }
            //Checking Validation
            if (empty($validationRes)) {
                if (!$user->isUserExistforRegistration($user_id, $email, $username)) {
                    if ($user->register($user_id, $fullname, $username, $email, $password)) {
                        $Res = array(
                            "registration" => "success",
                            "user_detail" => array(
                                "fullname" => $fullname,
                                "email" => $email,
                                "username" => $username,
                                "user_id" => $user_id,
                                "signup_payment" => "false"
                        ));
                        $result = $api->responseSuccess($Res);
                    } else {
                        $Res = array(
                            "registration" => "failed",
                            "message" => "Error while updating");
                        $result = $api->responseError($Res);
                    }
                } else {
                    $Res = array(
                        "registration" => "failed",
                        "message" => "User Already Exits");
                    $result = $api->responseError($Res);
                }
            } else {
                $Res = array(
                    "message" => "Invalid Input",
                );
                if (!empty($validationRes)) {
                    $Res["invalid_fields"] = $validationRes;
                }
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
