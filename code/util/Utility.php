<?php
Class Utility{

    /***************************************************************************************/
    //验证token有效性
    public static function valid(){
		$echoStr= $_GET["echostr"];

        //valid signature , option
        if(self::checkSignature()){
          echo $echoStr;
          exit;
        }
    }

    private static function checkSignature()
    {
    // you must define TOKEN by yourself
    	if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }

      	$signature = $_GET["signature"];
      	$timestamp = $_GET["timestamp"];
      	$nonce = $_GET["nonce"];

      	$token = TOKEN;
      	$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
      	sort($tmpArr, SORT_STRING);
      	$tmpStr = implode( $tmpArr );
      	$tmpStr = sha1( $tmpStr );

      	if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
  	}
 	/***************************************************************************************/



	//封装要发送的text数据：

	public static function WrapTextData($textTpl, $fromUsername, $toUsername, $time,$contentStr){
        $msgType = "text";
        //$resultStr = $textTpl . $fromUsername . $toUsername . $time . $contentStr;
		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
        return $resultStr;
	}

    public static function getArrayFromFile ($filePath) {
        $fileContents = file_get_contents($filePath, LOCK_EX);
        $fileArray = json_decode(trim($fileContents,chr(239).chr(187).chr(191)),true);
//        $fileArray = json_decode($fileContents, true, JSON_UNESCAPED_UNICODE);
        return $fileArray;
    }

}
