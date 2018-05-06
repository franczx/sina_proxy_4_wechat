
<?php

header('Content-type: application/json');

$raw_post_data = file_get_contents('php://input');  
$POST_VALUE = json_decode($raw_post_data,true); 

$method = $POST_VALUE['method'];

echo httpRequest('https://yourserver/'.$method, 'post', $POST_VALUE );

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

	curl_setopt($curl,CURLOPT_URL,$url);
	curl_setopt($curl,CURLOPT_POST,1 );
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  // 从证书中检查SSL加密算法是否存在
	curl_setopt($curl,CURLOPT_POSTFIELDS,$params);	
	
	if(isset($result)){
		$result=curl_exec($curl);
	}
	curl_close($curl);
	return $result;
}
 
?>
