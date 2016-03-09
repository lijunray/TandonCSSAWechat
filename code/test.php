<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 2016/2/29
 * Time: 17:29
 */
include_once("audience/MatcherEntry.php");
include_once ("Entry.php");
$openId = "1";
$userInput = "status";
$userInput = strtolower($userInput);

echo Entry::Entry_select($userInput, $openId);