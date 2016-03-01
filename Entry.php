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


Class Entry{

    public static function Entry_select($Content,$fromUserName){
        if (strncasecmp($Content,"B",1)==0||strncasecmp($Content,"G",1)==0){
            return Guests::getGuest($Content);
        }else{
	   $jsonContent = file_get_contents("json/users.json");
           return MatcherEntry::match($fromUserName, $Content, $jsonContent);
        }
    }
}
