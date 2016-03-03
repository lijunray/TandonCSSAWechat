<?php
/**
 * Created by PhpStorm.
 * User: shy
 * Date: 2/29/16
 * Time: 1:01 PM
 */
include_once ("guest/Guests.php");
include_once ("util/Utility.php");
include_once ("audience/MatcherEntry.php");
include_once ("audience/MatchUtil.php");

Class Entry{

    public static function Entry_select($content, $fromUserName){
        $content = strtolower($content);
        if (substr($content, 0, 1) == 'x') {
            return "你的答案已经保存在服务器啦！请等待答案最终揭晓吧！";
        }
        if (substr($content, 0, 4) == "/hi,"){
            //parse the content
            $guestNumber = substr($content, 4, 3);
            $guestComments = substr($content, 7);
            $userArray = Utility::getArrayFromFile("json/users.json");
            $senderIndex = MatchUtil::getSenderIndex($userArray, "openId", $fromUserName);
            if ($senderIndex == -1) {
                return "(#`O′)喂！没有在EventBrite上注册还想来CSSA钓妹（汉）子？(☄⊙ω⊙)☄不过也有可能是你输错微信号或者编号啦！再输入试试？";
            }
            $senderWechat = $userArray[$senderIndex]['wechat'];
            return Guests::saveComments($guestNumber, $guestComments, $senderWechat);
        } else {
           return MatcherEntry::match($fromUserName, $content);
        }
    }
}
