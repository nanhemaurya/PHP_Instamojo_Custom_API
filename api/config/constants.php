<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */





class Constants {
    public static $instamojoApiKey = "test_8c01976b3403da1a617c9ed5c1e";
    public static $instamojoAuthKey = "test_938c3d87bc252e3f07cfe1d50ad";
    public static $CURLOPT_HTTPHEADER = array("X-Api-Key:test_8c01976b3403da1a617c9ed5c1e", "X-Auth-Token:test_938c3d87bc252e3f07cfe1d50ad");

//    public static function CURLOPT_HTTPHEADER() {
//        return $this->CURLOPT_HTTPHEADER;
//    }

    public static function getInstamojoApiKey() {
        return $this->instamojoApiKey;
    }

    public static function getInstamojoAuthKey() {
        return $this->instamojoAuthKey;
    }

}
