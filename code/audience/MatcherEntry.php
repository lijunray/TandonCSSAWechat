<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 2016/2/28
 * Time: 22:36
 */

include_once("User.php");
include_once("Matcher.php");
class MatcherEntry {
    public static function match ($openId, $userInput) {
        $isMatched = Matcher::match($openId, $userInput);
        if($isMatched == "0") {
            return "你输(zen)错(me)东(zhe)西(me)了(meng)吧(a)！给你举个栗子！╮(╯▽╰)╭ 像这样输入微信号+编号最后四位就行啦：\"cssa001B\"";
        }
        else {
            return $isMatched;
        }

    }
}




