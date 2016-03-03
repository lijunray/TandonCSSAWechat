<?php



/**
* 
*/

	/**
	* 
	*/
	define("TOKEN", "weixin");
	include_once("util/Utility.php");
	include_once ("Entry.php");
	include_once ("guest/Guests.php");

	//Utility::valid();//判断token有效性


/*******************解析用户发送的数据**********************************************/
	$postObj = parseReceiveData();
	$fromUsername = $postObj->FromUserName;
	$toUsername = $postObj->ToUserName;
	$Content = trim($postObj->Content);
	$form_MsgType = $postObj->MsgType;
	$textTpl = "<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[%s]]></MsgType><Content><![CDATA[%s]]></Content></xml>";
	$time = time();

	/*$fromUsername = "yanyan1993";
	$toUsername = "tandoncssatest";
	$Content = "G01";
	$time="1456627036";*/
/*******************判断event**********************************************/
//消息类型


	//事件消息
	if($form_MsgType=="event")
	{
		//获取事件类型
		$form_Event = $postObj->Event;
		//订阅事件
		if($form_Event=="subscribe")
		{
			//回复欢迎文字消息
			$msgType = "text";
			$contentStr = "感谢您关注Tandon CSSA公众平台！[愉快][玫瑰]";
			$resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, $contentStr);
			echo $resultStr;
			exit;
		}

	}

/*******************判断入口**********************************************/
	else {
		$contentStr = Entry::Entry_select($Content, $fromUsername);
	}
/*******************封装返回的消息并发送**********************************************/

	$resultStr = Utility::WrapTextData($textTpl, $fromUsername, $toUsername, $time, $contentStr);
	echo $resultStr;

/*******************解析信息的函数**********************************************/

	function parseReceiveData(){
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		if (!empty($postStr)) { //若发送来的数据不为空
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);//解析数据
			return $postObj;
			//echo $postObj;
		}else{
			echo "请重新输入";
		}
	}