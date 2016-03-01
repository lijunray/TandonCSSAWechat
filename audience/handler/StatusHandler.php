<?php

/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 2016/2/28
 * Time: 21:03
 */
include_once("../util/MatchUtil.php");
class StatusHandler {

    public static function handle ($openId, $jsonContent) {

        $userArray = json_decode($jsonContent, true);
        $senderIndex = MatchUtil::getSenderIndex($userArray, "openId", $openId);

        if ($senderIndex ==  -1) {
            return "Input your wechat account and serial number like this \"cssa001B\" first!";
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
            $matcher = $userArray[$matcherIndex];
            $matcherInfo = "Name: " . $matcher["userName"] . "\n" .
                "Age: " . $matcher['age'] . "\n" .
                "University: " . $matcher['university'] . "\n" .
                "Height: " . $matcher['height'] . "\n" .
                "Weight: " . $matcher['weight'] . "\n" .
                "Interests: " . $matcher['interest'] . "\n" .
                "Personality: " . $matcher['personality'] . "\n" ;
            return "Amazing! Both of you and him/her have approved to share your personal information! Here it is:\n" .
            $matcherInfo ."After this, if you are interested in contacting him/her, just type in \"exchange\"!";
        }
        elseif ($senderFlag == "1" && $matcherFlag == "2") {
            return "He/she has approved to share his/her contact, waiting for your decision! \"exchange\" to approve!";
        }
        elseif ($senderFlag == "2" && $matcherFlag == "1") {
            return "You have approved to share your contact to him/her. Just wait for his/her approve!";
        }
        elseif ($senderFlag == "2" && $matcherFlag == "2") {
            return "Congratulations! Both of you have approved to share contacts! Here is his/her wechat account: " .
            $userArray[$matcherIndex]['wechat'] . ". Now add him/her!";
        }
        elseif ($senderFlag = "3") {
            return "Congratulations! Both of you have approved to share contacts! Here is his/her wechat account: " .
            $userArray[$matcherIndex]['wechat'] . ". Now add him/her!";
        }

    }


}