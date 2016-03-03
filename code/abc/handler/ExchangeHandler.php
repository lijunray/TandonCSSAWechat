<?php

/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 2016/2/28
 * Time: 21:45
 */

include_once("../util/MatchUtil.php");

class ExchangeHandler {

    public static function exchange ($openId, $jsonContent) {
        $userArray = json_decode($jsonContent, true);
        $senderIndex = MatchUtil::getSenderIndex($userArray, "openId", $openId);
        if ($senderIndex == -1) {
            return "Input your wechat account and serial number like this \"cssa001G\" first!";
        }

        $senderSerialNumber = $userArray[$senderIndex]['serialNumber'];
        $matcherIndex = MatchUtil::getMatcher($userArray, $senderSerialNumber);

        if ($matcherIndex == -1) {
            return "You have input your serial number already. Just wait for him/her!";
        }

        $senderFlag = $userArray[$senderIndex]['flag'];
        $matcherFlag = $userArray[$matcherIndex]['flag'];
        if ($senderFlag == "1" && $matcherFlag == "0") {
            return "You have input your serial number already. Just wait for him/her!";
        }
        elseif ($senderFlag == "1" && $matcherFlag == "1") {
            MatchUtil::saveInputs($userArray, $senderIndex, $userArray[$senderIndex]['serialNumber'], $openId, "2");
            return "You have successfully approved to share your contacts! Now just wait and check \"status\" after some time!";
        }
        elseif ($senderFlag == "1" && $matcherFlag == "2") {
            MatchUtil::saveInputs($userArray, $senderIndex, $userArray[$senderIndex]['serialNumber'], $openId, "3");
            MatchUtil::saveInputs($userArray, $matcherIndex, $userArray[$matcherIndex]['serialNumber'], $userArray[$matcherIndex]['openId'], "3");
            return "Congratulations! Both of you have approved to share contacts! Here is his/her wechat account: " .
            $userArray[$matcherIndex]['wechat'] . ". Now add him/her!";
        }
        elseif ($senderFlag == "2") {
            return "You have successfully approved to share your contacts! Now just wait and check \"status\" after some time!";
        }
        elseif ($senderFlag == "3") {
            return "You have matched to a person. Do not match again! Send \"status\" to check!";
        }

    }
}