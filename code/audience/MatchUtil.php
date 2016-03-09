<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 2016/2/28
 * Time: 16:51
 */
include_once("User.php");

class MatchUtil {

    public static function getMatcher ($userArray, $serialNumber) {
        $senderGender = $serialNumber[3];
        $senderNumber = substr($serialNumber, 0, 3);
        $matcherGender = $senderGender == "b" ? "g" : "b" ;
        $matcherNumber = $senderNumber;
        $matcherSerialNumber = $matcherNumber . $matcherGender;
        $length = count($userArray);
        for ($i = 0; $i < $length; $i++) {
            if ($userArray[$i]['serialNumber'] == $matcherSerialNumber) {
                return $i;
            }
        }
        return -1;
    }

    static public function checkNumber ($userInput) {
        $userInput = str_replace(" ", "", $userInput);//去掉空格
        $senderNumber = substr($userInput, 0, 3);
        $senderGender = $userInput[3];
        if (strlen($senderNumber) != 3 || preg_match('/[A-Za-z]/',$senderNumber) || ($senderGender != 'b'
            && $senderGender != 'g')) {
            return "你输(zen)错(me)东(zhe)西(me)了(meng)吧(a)！给你举个栗子！╮(╯▽╰)╭ 像这样输入微信号+编号最后四位就行啦：\"cssa001B\" ";
        }
        return "OK";
    }

    public static function getSenderIndex ($userArray, $key, $value) {
        $length = count($userArray);
        for ($i = 0; $i < $length; $i++) {
            if (array_key_exists($key, $userArray[$i]) && $userArray[$i]["$key"] == $value) {
                return $i;
            }
        }
        return -1;
    }

    public static function saveInputs($userArray, $senderIndex, $serialNumber, $openId, $flag) {
        $filePath = 'json/users.json';
        $userArray[$senderIndex]['serialNumber'] = $serialNumber;
        $jjj = json_encode($openId);
        $qqq = json_decode($jjj, true);
        $userArray[$senderIndex]['openId']=$qqq[0];
        $userArray[$senderIndex]['flag'] = $flag;
        self::save($userArray);
    }

    public static function save ($userArray) {
        $filePath = 'json/users.json';
        $jsonFromArray = json_encode($userArray);
        file_put_contents($filePath, $jsonFromArray, LOCK_EX);
    }
}