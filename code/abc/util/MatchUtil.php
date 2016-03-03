<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 2016/2/28
 * Time: 16:51
 */
include_once("../dao/User.php");

class MatchUtil {

    private static $filePath = '../json/users.json';

    public static function getArrayFromFile () {
        return json_decode(file_get_contents(self::$filePath), true);
    }

    public static function jsonToUsers ($jsonObj, $index) {
        $array = json_decode($jsonObj, true);
        $obj = $array[$index];
        $user = new User($obj['openId'], $obj['orderNumber'], $obj['userName'], $obj['email'], $obj['gender'],
            $obj['age'], $obj['university'], $obj['wechat'], $obj['height'], $obj['weight'], $obj['interest'],
            $obj['personality'], $obj['input'], $obj['flag']);
        return $user;
    }

    public static function getMatcher ($userArray, $serialNumber) {
        $senderGender = $serialNumber[3];
        $senderNumber = substr($serialNumber, 0, 3);
        $matcherGender = $senderGender == "B" ? "G" : "B" ;
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
        if (strlen($senderNumber) != 3 || preg_match('/[A-Za-z]/',$senderNumber) || $senderGender != 'B'
            && $senderGender != 'G') {
            return "输入有误！请输入微信号+编号末四位！如aaaa001B！";
        }
        return "OK";
    }

    public static function getSenderIndex ($userArray, $key, $value) {
        $length = count($userArray);
        for ($i = 0; $i < $length; $i++) {
            if ($userArray[$i][$key] == $value) {
                return $i;
            }
        }
        return -1;
    }

    public static function saveInputs($userArray, $senderIndex, $serialNumber, $openId, $flag) {
        $userArray[$senderIndex]['serialNumber'] = $serialNumber;
        $userArray[$senderIndex]['openId'] = $openId;
        $userArray[$senderIndex]['flag'] = $flag;
        $jsonFromArray = json_encode($userArray);
        if (is_writable(self::$filePath)) {
            echo "11";
        }
        else {
            echo "22";
        }
        file_put_contents(self::$filePath, $jsonFromArray);
    }
}