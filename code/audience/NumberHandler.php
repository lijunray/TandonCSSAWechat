<?php

/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 2016/2/28
 * Time: 16:44
 */
include_once("MatchUtil.php");
include_once $_SERVER['DOCUMENT_ROOT']."\code\util\Utility.php";

class NumberHandler {

    public static function handle ($wechat, $serialNumber, $openId) {

        $userArray = Utility::getArrayFromFile("json/users.json");
        if (self::openIdExists($openId, $userArray) == 0) {
            return "(⊙▽⊙)你已经输入过了你的微信号和号码，做一枚安静的美男（女）子等待TA的回复或者输入 \"status\" 查看当前状态！\n如果你之前输错了...请发送 \"B-1\" 加上 \"【我是笨蛋输错账号惹】\" 加上你正确的账号，程序员哥哥会给你改过来的，吧...=。=";
        }

        //Does wechat exist?
        $senderIndex = MatchUtil::getSenderIndex($userArray, "wechat", $wechat);
        if ($senderIndex == -1) {
            return "(#`O′)喂！没有在EventBrite上注册还想来CSSA钓妹（汉）子？(☄⊙ω⊙)☄不过也有可能是你输错微信号或者编号啦！再输入试试？";
        }

        $matcherIndex = MatchUtil::getMatcher($userArray, $serialNumber);
        if ($matcherIndex != -1 && $userArray[$matcherIndex]['flag'] == "3") {
            return "找到TA了噜...但是...人家已经跟别人跑啦！凸(艹皿艹 )你是不是输错号码了？";
        }


        //flag judgement
        //There are 3 kinds of statement for a user
        //Originally flag = "0", meaning this userArray[senderIndex] object does not have openId and userArray[senderIndex]Number, can't be matched.
        //if flag = "1", meaning this userArray[senderIndex] object already has openId and userArray[senderIndex]Number, but not matched. Ready for personal information Exchange.
        //if flag = "2", meaning this userArray[senderIndex] object has exchanged personal information, ready for exchanging contact information.
        $senderFlag = $userArray[$senderIndex]['flag'];
        if ($senderFlag == "0") {
            MatchUtil::saveInputs($userArray, $senderIndex, $serialNumber, $openId, "1");
            return "\\(^o^)/YES!你的信息已经保存成功啦，耐心等一会儿然后输入 \"status\" 检查你的匹配状态！当然你现在也是可以检查的啦...";
        }
        elseif ($senderFlag == "1") {
            return "(ノಠ益ಠ)ノ彡┻━┻!你的信息已经输入过了！再输入服务器君就要生气惹！但是你可以输入 \"status\" 查看当前的状态哈！";
        }
        elseif ($senderFlag == "2" || $senderFlag == "3") {
            return "坏人～(　TロT)σ你已经跟别人匹配过了！想脚踏两条船吗？！小心服务器君一生气告诉TA！发送 \"status\" 查看当前状态！";
        }
        else {
            return "ε(┬┬﹏┬┬)3一些程序猿哥哥没有预料到的事情发生了...如果你愿意帮助程序猿哥哥改进的话，请输入\"B-1\"加上你的输入内容...";
        }
    }

    private static function openIdExists($openId, $userArray) {
        for ($i = 0; $i < count($userArray); $i++) {
            if (array_key_exists('openId' ,$userArray[$i])) {
                if ($userArray[$i]['openId'] == $openId) {
                    return 0;
                }
            }
        }
        return 1;
    }
}