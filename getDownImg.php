<?php

header('Content-type: image/jpeg');
header('content-disposition: attachment');


$method = $_GET['method'];
echo httpRequest('https://yourserver/'.$method, 'get', $_GET );

function httpRequest($url,$method,$params=array()){
	if(trim($url)==''||!in_array($method,array('get','post'))||!is_array($params)){
		return false;
	}
	$result = "";
	$timeout=30;
	$curl=curl_init();
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($curl,CURLOPT_HEADER,0 ) ;

	/** Get --BEGIN-- */
			$str='?';
			foreach($params as $k=>$v){
				$cV = urlencode($v);
				$str.=$k.'='.$cV.'&';
			}
			$str=substr($str,0,-1);
			$url.=$str;//$url=$url.$str;
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  // 从证书中检查SSL加密算法是否存在
			curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
			curl_setopt($curl,CURLOPT_URL,$url);
	/** Get --END-- */
	
	if(isset($result)){
		$result=curl_exec($curl);
	}
	curl_close($curl);
	return $result;
}
 
?>
