<?php

/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 2016/2/28
 * Time: 16:44
 */
include_once("../util/MatchUtil.php");

class NumberHandler {

    public static function handle ($wechat, $serialNumber, $openId, $jsonContent) {

        $userArray = json_decode($jsonContent, true);
        //Does wechat exist?
        $senderIndex = MatchUtil::getSenderIndex($userArray, "wechat", $wechat);
        if ($senderIndex == -1) {
            return "You did not register on EventBrite or input wrong wechat account!";
        }

        $matcherIndex = MatchUtil::getMatcher($userArray, $serialNumber);
        if ($matcherIndex != -1 && $userArray[$matcherIndex]['flag'] == "3") {
            return "Found her/him, but he/she has been matched. Check your input and send again.";
        }
        var_dump($userArray);

        //flag judgement
        //There are 3 kinds of statement for a user
        //Originally flag = "0", meaning this userArray[senderIndex] object does not have openId and userArray[senderIndex]Number, can't be matched.
        //if flag = "1", meaning this userArray[senderIndex] object already has openId and userArray[senderIndex]Number, but not matched. Ready for personal information Exchange.
        //if flag = "2", meaning this userArray[senderIndex] object has exchanged personal information, ready for exchanging contact information.
        if ($userArray[$senderIndex]['flag'] == "0") {
            MatchUtil::saveInputs($userArray, $senderIndex, $serialNumber, $openId, "1");
            return "Your information has been saved and now wait or input \"status\" to check your matching status.";
        }
        elseif ($userArray[$senderIndex]['flag'] == "1") {
            return "You have input your number already, do not input again. Check status by sending \"status\".";
        }
        elseif ($userArray[$senderIndex]['flag'] == "2") {
            return "You have matched to a person already! Do not match again!";
        }
        elseif ($userArray[$senderIndex]['flag'] == "3") {
            return "You have matched to a person. Send \"status\" to check!";
        }
        else {
            return "Your input is invalid.";
        }
    }
}