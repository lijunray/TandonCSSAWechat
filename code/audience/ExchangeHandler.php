<?php

/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 2016/2/28
 * Time: 21:45
 */

include_once("MatchUtil.php");
include_once $_SERVER['DOCUMENT_ROOT']."\code\util\Utility.php";

class ExchangeHandler {

    public static function exchange ($openId) {
        $userArray = Utility::getArrayFromFile("/json/users.json");
        $senderIndex = MatchUtil::getSenderIndex($userArray, "openId", $openId);
        if ($senderIndex == -1) {
            return "还没输入你的微信号加编号怎么钓妹（汉）子你告诉我怎么钓！好吧好吧！给你举个栗子！╮(╯▽╰)╭ 像这样输入就行啦：\"cssa001B\" ";
        }

        $senderSerialNumber = $userArray[$senderIndex]['serialNumber'];
        $matcherIndex = MatchUtil::getMatcher($userArray, $senderSerialNumber);

        if ($matcherIndex == -1) {
            return "(⊙▽⊙)你已经输入过了你的微信号和号码，做一枚安静的美男（女）子等待TA的回复或者输入 \"status\" 查看当前状态！
            如果你之前输错了...请发送 \"B-1\" 加上 \"【我是笨蛋输错账号惹】\" 加上你正确的账号，程序员哥哥会给你改过来的，吧...=。=";
        }

        $senderFlag = $userArray[$senderIndex]['flag'];
        $matcherFlag = $userArray[$matcherIndex]['flag'];
        if ($senderFlag == "1" && $matcherFlag == "0") {
            return "(⊙▽⊙)你已经输入过了你的微信号和号码，做一枚安静的美男（女）子等待TA的回复或者输入 \"status\" 查看当前状态！
            如果你之前输错了...请发送 \"B-1\" 加上 \"【我是笨蛋输错账号惹】\" 加上你正确的账号，程序员哥哥会给你改过来的，吧...=。=";
        }
        elseif ($senderFlag == "1" && $matcherFlag == "1") {
            MatchUtil::saveInputs($userArray, $senderIndex, $userArray[$senderIndex]['serialNumber'], $openId, "2");
            return "O(∩_∩)O~~你已经同意交换联系方式了，然而TA还需要考虑...可能半个小时吧！再等等吧~~~";
        }
        elseif ($senderFlag == "1" && $matcherFlag == "2") {
            $userArray[$senderIndex]['flag'] = "3";
            $userArray[$matcherIndex]['flag'] = "3";
            MatchUtil::save($userArray);
            return "羡慕ing...但是还是恭喜！你！们！都！同！意！交！换！联！系！方！式！啦！还不快加TA？" . $userArray[$matcherIndex]['wechat'];
        }
        elseif ($senderFlag == "2") {
            return "O(∩_∩)O~~你已经同意交换联系方式了！发送 \"status\" 查看当前状态！";
        }
        elseif ($senderFlag == "3") {
            return "坏人～(　TロT)σ你已经跟别人匹配过了！想脚踏两条船吗？！小心服务器君一生气告诉TA！发送 \"status\" 查看当前状态！";
        }

    }

}