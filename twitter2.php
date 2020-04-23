<?php

	$twitter_api_key		='WnPWUQmqKRAPSJcGR5idGL7hb';
	$twitter_api_s_key		='mDYvJu39M759tOjgtgIl4gce4Er1ZibUchxwIKS8AIfMtyBHgv';
	$twitter_token			='1126844267576430593-2jX1VNjIlJNbTCg3aWp2amYJtIBO9e';
	$twitter_s_token		='vhYgGVBb1u6qfutPPEwdJpysZGbnwoOfOCAYCIGXKgABj';

	$request_url = 'https://api.twitter.com/1.1/users/lookup.json';
	$request_method = 'GET' ;

	$params01 = array(
//		"user_id" => "1528352858,2905085521",
		"screen_name" => "mikarika1125,serra_geddon,135_dream,akane19920606,donutnegi",

	) ;

	$signature_key = rawurlencode( $twitter_api_s_key ) . '&' . rawurlencode($twitter_s_token) ;
	$params02 = array(
		'oauth_token' => $twitter_token,
		'oauth_consumer_key' => $twitter_api_key ,
		'oauth_signature_method' => 'HMAC-SHA1' ,
		'oauth_timestamp' => time() ,
		'oauth_nonce' => microtime() ,
		'oauth_version' => '1.0' ,
	) ;

	$params03 = array_merge( $params01 , $params02 ) ;
	ksort( $params03 ) ;

	$request_params = http_build_query( $params03 , '' , '&' ) ;
	$request_params = str_replace( array( '+' , '%7E' ) , array( '%20' , '~' ) , $request_params ) ;
	$request_params = rawurlencode( $request_params ) ;

	$encoded_request_method = rawurlencode( $request_method ) ;
	$encoded_request_url = rawurlencode( $request_url ) ;

	$signature_data = $encoded_request_method . '&' . $encoded_request_url . '&' . $request_params ;
	$hash = hash_hmac( 'sha1' , $signature_data , $signature_key , TRUE ) ;
	$signature = base64_encode( $hash ) ;
	$params03['oauth_signature'] = $signature ;
	$header_params = http_build_query( $params03 , '' , ',' ) ;

	$context = array(
		'http' => array(
			'method' => $request_method , // リクエストメソッド
			'header' => array(			  // ヘッダー
				'Authorization: OAuth ' . $header_params ,
			) ,
		) ,
	) ;

	if( $params01 ) {
		$request_url .= '?' . http_build_query( $params01 ) ;
	}

	$curl = curl_init() ;
	curl_setopt( $curl, CURLOPT_URL , $request_url ) ;
	curl_setopt( $curl, CURLOPT_HEADER, 1 ) ; 
	curl_setopt( $curl, CURLOPT_CUSTOMREQUEST , $context['http']['method'] ) ;
	curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER , false ) ;
	curl_setopt( $curl, CURLOPT_RETURNTRANSFER , true ) ;
	curl_setopt( $curl, CURLOPT_HTTPHEADER , $context['http']['header'] ) ;
	curl_setopt( $curl , CURLOPT_TIMEOUT ,10) ;	// タイムアウトの秒数

	$res1 = curl_exec( $curl ) ;
	$res2 = curl_getinfo( $curl ) ;
	curl_close( $curl ) ;

	$json = substr( $res1, $res2['header_size'] ) ;
	$obj = json_decode( $json ) ;
	

for($n=0;$n<count($obj);$n++){
	print($obj[$n]->id."<br>\n");
}


?>
