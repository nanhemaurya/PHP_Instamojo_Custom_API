<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'core.php';
include_once 'database.php';

class user {

    public $db;
    public $link;
    public $api;

    public function __construct() {
        $database = new database();
        $this->db = $database->db;
        $this->link = $database->link;

        $this->api = new api();
    }

    public function register($user_id, $full_name, $username, $email, $password) {
        $query = "INSERT INTO `users`( `user_id`, `full_name`, `username`, `email`, `password`, `is_signup_payment_done`, `signup_payment_request`, `signup_payment_response`) VALUES ('$user_id','$full_name','$username','$email','$password','false','','')";
        if (mysqli_query($this->link, $query)) {
            return TRUE;
        }
        return FALSE;
    }

    public function getLoginToken($user_id_email_or_username, $password) {
        $query = "SELECT `user_id` FROM `users` WHERE ((`username`='$user_id_email_or_username' OR `email`='$user_id_email_or_username' OR `user_id`='$user_id_email_or_username') AND (`password`='$password'))";
        $result = mysqli_query($this->link, $query);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $user_id = $row['user_id'];
            return $this->genLoginToken($user_id, $password);
        }
    }

    public function getUserDetail($user_id_email_or_username, $password) {
        $query = "SELECT `user_id`, `full_name`, `email` FROM `users` WHERE ((`username`='$user_id_email_or_username' OR `email`='$user_id_email_or_username' OR `user_id`='$user_id_email_or_username') AND (`password`='$password'))";
        $result = mysqli_query($this->link, $query);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $user_id = $row['user_id'];
            $full_name = $row['full_name'];
            $email = $row['email'];

            $res = array(
                "user_id" => $user_id,
                "email" => $email,
                "full_name" => $full_name
            );
            return $res;
        }
    }

    public function getUserDetailByToken($user_id_email_or_username, $token) {
        $query = "SELECT `user_id`, `full_name`, `email`,`password` FROM `users` WHERE (`username`='$user_id_email_or_username' OR `email`='$user_id_email_or_username' OR `user_id`='$user_id_email_or_username')";
        $result = mysqli_query($this->link, $query);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $user_id = $row['user_id'];
            $password = $row['password'];
            $full_name = $row['full_name'];
            $email = $row['email'];
            $res = array(
                "user_id" => $user_id,
                "email" => $email,
                "full_name" => $full_name
            );
        }
        if ($token == $this->genLoginToken($user_id, $password)) {
            return $res;
        }
    }

    public function isUserExistforLogin($user_id_email_or_username, $password) {
        $query = "SELECT `user_id` FROM `users` WHERE ((`username`='$user_id_email_or_username' OR `email`='$user_id_email_or_username' OR `user_id`='$user_id_email_or_username') AND (`password`='$password'))";
        $result = mysqli_query($this->link, $query);
        if (mysqli_num_rows($result) == 1) {
            return TRUE;
//            $row = mysql_fetch_array($result,MYSQLI_ASSOC);
//            $user_id = $row['user_id'];
//            return $this->genLoginToken($user_id, $password);
        }
        return FALSE;
    }

    public function loginByToken($user_id_email_or_username, $token) {
        if ($this->isUserExist($user_id_email_or_username)) {
            $query = "SELECT `user_id`,`password` FROM `users` WHERE (`username`='$user_id_email_or_username' OR `email`='$user_id_email_or_username' OR `user_id`='$user_id_email_or_username')";
            $result = mysqli_query($this->link, $query);
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $user_id = $row['user_id'];
                $password = $row['password'];
            }
            if ($token == $this->genLoginToken($user_id, $password)) {
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }

    public function isUserExist($user_id_email_or_username) {
        $query = "SELECT `user_id`, `username`, `email` FROM `users` WHERE (`username`='$user_id_email_or_username' OR `email`='$user_id_email_or_username' OR `user_id`='$user_id_email_or_username')";
        $result = mysqli_query($this->link, $query);
        if (mysqli_num_rows($result) == 1) {
            return TRUE;
        }
        return FALSE;
    }

    public function isUserExistforRegistration($user_id, $email, $username) {
        $query = "SELECT `unique_id` FROM `users` WHERE (`username`='$username' OR `email`='$email' OR `user_id`='$user_id')";
        $result = mysqli_query($this->link, $query);
        if (mysqli_num_rows($result) > 0) {
            return TRUE;
        }else{
			return 0;
		}
		
	}

    private function genLoginToken($user_id, $password) {
        return md5("$user_id.$password");
    }

    public function validStrLen($str, $min, $max) {
        $len = strlen($str);
        if ($len < $min) {
            return FALSE;
        } elseif ($len > $max) {
            return FALSE;
        }
        return TRUE;
    }

    public function validateStringContainsNumberOnly($x) {
        $numeric = "0123456789";
        for ($i = 0; $i < strlen($x); $i++) {
            if (strlen(strchr($numeric, $x[$i])) <= 0) {
                return 0;
            }
        }
        return 1;
    }

    public function updatePaymentRequest($userId, $data) {
        $query = "UPDATE `users` SET `signup_payment_request`='$data' WHERE `user_id`='$userId'";
        if (mysqli_query($this->link, $query)) {
            return TRUE;
        }
        return FALSE;
    }

    public function updatePaymentResponse($userId, $data) {
        $query = "UPDATE `users` SET `signup_payment_response`='$data' WHERE `user_id`='$userId'";
        if (mysqli_query($this->link, $query)) {
            return TRUE;
        }
        return FALSE;
    }

    public function updateIsSignUpPayementDone($userId, $boolean) {
        $query = "UPDATE `users` SET `is_signup_payment_done`='$boolean' WHERE `user_id`='$userId'";
        if (mysqli_query($this->link, $query)) {
            return TRUE;
        }
        return FALSE;
    }

    public function updatePaymentResponseAndStatus($userId, $data) {
        $query = "UPDATE `users` SET `is_signup_payment_done`='true',`signup_payment_response`='$data' WHERE `user_id`='$userId'";
        if (mysqli_query($this->link, $query)) {
            return TRUE;
        }
        return FALSE;
    }

    public function getIsSignUpPayementDone($userId) {
        $query = "SELECT `is_signup_payment_done` FROM `users` WHERE (`username`='$userId' OR `email`='$userId' OR `user_id`='$userId')";
        $result = mysqli_query($this->link, $query);
//        if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $s = $row['is_signup_payment_done'];
        return $s;
//        }
//        return FALSE;
    }

}

//
//$test = new user();
//print_r($test->genLoginToken("hjgh", "ghhjgjh"));
