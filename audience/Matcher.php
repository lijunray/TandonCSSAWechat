<?php
header("Content-Type:text/html;   charset=utf-8");
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 2016/2/28
 * Time: 16:48
 */

include_once("handler/NumberHandler.php");
include_once("handler/StatusHandler.php");
include_once("handler/ExchangeHandler.php");
include_once("util/MatchUtil.php");
include_once("dao/User.php");

class Matcher {
    //userInput: wechat.serialNumber. i.e. rayleelove001B
    public static function match ($openId, $userInput, $jsonContent) {
        $length = strlen($userInput);
        if ($length <= 4) {
            return "0";
        }
        $serialNumber = substr($userInput, -4);
        $wechat = substr($userInput, 0, $length - 4);


        if ($userInput == "exchange") {
            return ExchangeHandler::exchange($openId, $jsonContent);
        }
        elseif ($userInput == "status") {
            return StatusHandler::handle($openId, $jsonContent);
        }
        else {
            $isOk = MatchUtil::checkNumber($serialNumber);
            if ($isOk != "OK") {
                return $isOk;
            }
            return NumberHandler::handle($wechat, $serialNumber, $openId, $jsonContent);
        }

    }

}






















//
//$userArray = array();
//
//array_push($userArray, $user1, $user2);
//
////var_dump($userArray);
//
//$savedJson = json_encode($userArray);
//
//$user = MatchUtil::jsonToUser($savedJson, 0);
//var_dump($user);
//
//$jsonToArray = json_decode($savedJson, true);
//
////file_put_contents("users.json", $savedJson);