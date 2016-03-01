<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 2016/2/29
 * Time: 17:29
 */
include_once("MatcherEntry.php");
$json = file_get_contents("users.json");
echo MatcherEntry::match("qwe12qwg1213", "ray1001B", $json);