<?php
include_once $_SERVER['DOCUMENT_ROOT']."\code\util\Utility.php";
    class Guests
    {
        public static function saveComments ($guestNumber, $guestComments, $senderWechat) {
            $guestsArray = Utility::getArrayFromFile("json/comments.json");
            var_dump($guestsArray);
            $guestGender = substr($guestNumber, 0, 1);
            if ($guestGender != "g" && $guestGender != "b") {
                return "小可爱，除了Girl和Boy，你觉得世界上还有第三种性别吗？什么？你说Man和Woman？你现在知道你为什么找不到男（女）朋友了吗？[微笑]";
            }
            $guestNumber = $guestGender == "g" ? (int)substr($guestNumber, 1, 2) - 1 : ((int)substr($guestNumber, 1, 2)) + 11;
            if (!array_key_exists($guestNumber, $guestsArray)) {
                return "你是不是输错嘉宾编号了？我们没有找到你输入的嘉宾哦！再试一次吧！";
            }
            $guest = $guestsArray[$guestNumber];
            var_dump($guest);
            if (!is_array($guest)) {
                return "guest不是array";
            }
            self::putComments($guestComments, $senderWechat, $guestsArray, $guestNumber);
            return "你的评论已经成功保存啦！我们会在活动结束后发给嘉宾的哟！下面是嘉宾个人信息：" . $guest['info'];
        }

        private static function putComments ($guestComments, $senderWechat, $guestsArray, $guestNumber) {
            echo $guestComments;
            if (!array_key_exists($senderWechat, $guestsArray[$guestNumber]["comments"])) {
                $guestsArray[$guestNumber]["comments"]["$senderWechat"] = $guestComments;
            }
            $guestsArray[$guestNumber]["comments"]["$senderWechat"] .= "|" . $guestComments;
            $jsonToBeSaved = json_encode($guestsArray, JSON_UNESCAPED_UNICODE);
            file_put_contents("json/comments.json", $jsonToBeSaved, LOCK_EX);
        }
    }


