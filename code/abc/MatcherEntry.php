<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 2016/2/28
 * Time: 22:36
 */

include_once("dao/User.php");
include_once("Matcher.php");
class MatcherEntry {
    public static function match ($openId, $userInput, $jsonContent) {
        $isMatched = Matcher::match($openId, $userInput, $jsonContent);
        if($isMatched == "0") {
            return "输入有误！请输入微信号+编号末四位！如aaaa001B！";
        }
        else {
            return $isMatched;
        }

    }
}




