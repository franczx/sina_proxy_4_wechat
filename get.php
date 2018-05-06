
<?php

header('Content-type: application/json');

$method = $_GET['method'];
echo httpRequest('https://yourserver/'.$method, 'get', $_GET );


function httpRequest($url,$method,$params=array()){
	if(trim($url)==''||!in_array($method,array('get','post'))||!is_array($params)){
		return false;
	}
	$result = "";
	$timeout = 30;
	$curl=curl_init();
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($curl,CURLOPT_HEADER,0 ) ;
	curl_setopt ($curl, CURLOPT_CONNECTTIMEOUT, $timeout);

			$str='?';
			foreach($params as $k=>$v){
				$cV = urlencode($v);
				$str.=$k.'='.$cV.'&';
			}
			$str=substr($str,0,-1);
			$url.=$str;//$url=$url.$str;
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //这个是重点,规避ssl的证书检查。
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 跳过host验证
			curl_setopt($curl,CURLOPT_URL,$url);
	
	if(isset($result)){
		$result=curl_exec($curl);
	}
	curl_close($curl);
	return $result;
}
 
?>
