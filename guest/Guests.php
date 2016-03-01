<?php
include_once ("../util/Utility.php");
    class Guests
    {
        public static function getGuest($Content)
        {
            $Guest = array("G01" => "苏昊妍， 年龄：22， 爱好：唱歌",
                "G02" => "陈冰花， 年龄：22， 爱好：唱歌");
            //^\d[0]$\d[!0]
            foreach ($Guest as $key => $value) {
                if ($key == $Content) {
                    $contentStr = $value;
                    break;
                } else {
                    $contentStr = "对不起，请正确输入嘉宾编号，例如：查询一号女嘉宾信息，输入：G01";
                }
            }
            return $contentStr;

        }
    }


