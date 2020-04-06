<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'constants.php';

class api {

    public function createPaymentRequest($payload_params) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://test.instamojo.com/api/1.1/payment-requests/');
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Constants::$CURLOPT_HTTPHEADER);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload_params));
        $response = curl_exec($ch);
        curl_close($ch);
        $resArr = json_decode($response, TRUE);
        return json_encode($resArr, JSON_PRETTY_PRINT);
    }

    

    public function getPaymentRequestDetails($id) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://www.instamojo.com/api/1.1/payment-requests/$id/");
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Constants::$CURLOPT_HTTPHEADER);
        $response = curl_exec($ch);
        curl_close($ch);
        $resArr = json_decode($response, TRUE);
        return json_encode($resArr, JSON_PRETTY_PRINT);
    }

    public function getPaymentFullDetail($id, $payment_id) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.instamojo.com/api/1.1/payment-requests/$id/$payment_id/");
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Constants::$CURLOPT_HTTPHEADER);
        $response = curl_exec($ch);
        curl_close($ch);
        $resArr = json_decode($response, TRUE);
        return json_encode($resArr, JSON_PRETTY_PRINT);
    }
    
    public function getPaymentDetail($payment_id) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.instamojo.com/api/1.1/payments/$payment_id/");
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Constants::$CURLOPT_HTTPHEADER);
        $response = curl_exec($ch);
        curl_close($ch);
        $resArr = json_decode($response, TRUE);
        return json_encode($resArr, JSON_PRETTY_PRINT);
    }

    public function responseError($response) {
        $resArray = array(
            "success" => TRUE,
            "type" => "error",
            "response" => $response
        );
        return $resArray;
    }

    public function responseSuccess($response) {
        $resArray = array(
            "success" => TRUE,
            "type" => "success",
            "response" => $response
        );
        return $resArray;
    }

}
