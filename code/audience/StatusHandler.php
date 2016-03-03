<?php

/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 2016/2/28
 * Time: 21:03
 */
include_once("MatchUtil.php");
include_once $_SERVER['DOCUMENT_ROOT']."\code\util\Utility.php";
class StatusHandler {

    public static function handle ($openId) {

        $userArray = Utility::getArrayFromFile("json/users.json");
        $senderIndex = MatchUtil::getSenderIndex($userArray, "openId", $openId);

        if ($senderIndex ==  -1) {
            return "还没输入你的微信号加编号怎么钓妹（汉）子你告诉我怎么钓！好吧好吧！给你举个栗子！╮(╯▽╰)╭ 像这样输入就行啦：\"cssa001B\" ";
        }

        $senderSerialNumber = $userArray[$senderIndex]['serialNumber'];
        $matcherIndex = MatchUtil::getMatcher($userArray, $senderSerialNumber);
        if ($matcherIndex == -1) {
            return "TA好像还没有输入TA的信息给服务器君...再等等看吧...(⊙ˍ⊙)...";
        }

        $senderFlag = $userArray[$senderIndex]['flag'];
        $matcherFlag = $userArray[$matcherIndex]['flag'];

        if ($senderFlag == "1" && $matcherFlag == "0") {
            return "TA好像还没有输入TA的信息给服务器君...再等等看吧...(⊙ˍ⊙)...";
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
            return "\\(^o^)/YES!TA同意分享给你TA的信息啦！不管是不是满意都是缘分哦！\n" . $matcherInfo . "怎么样！要不要试着交换一下联系方式！确认的话输入 \"exchange\"!";
        }
        elseif ($senderFlag == "1" && $matcherFlag == "2") {
            return "悄悄告诉你！TA！已！经！同！意！交！换！联！系！方！式！惹！想交换的话输入 \"exchange\" !";
        }
        elseif ($senderFlag == "2" && $matcherFlag == "1") {
            return "O(∩_∩)O~~你已经同意交换联系方式了，然而TA还需要考虑...可能半个小时吧！再等等吧~~~";
        }
        elseif ($senderFlag == "2" && $matcherFlag == "2") {
            return "羡慕ing...但是还是恭喜！你！们！都！同！意！交！换！联！系！方！式！啦！还不快加TA？ " . $userArray[$matcherIndex]['wechat'];
        }
        elseif ($senderFlag = "3") {
            return "羡慕ing...但是还是恭喜！你！们！都！同！意！交！换！联！系！方！式！啦！还不快加TA？ " . $userArray[$matcherIndex]['wechat'];
        }

    }


}