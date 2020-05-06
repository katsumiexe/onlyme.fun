<?
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/no_session.php");
include_once("./library/api.php");

$sql ="SELECT * FROM me_thanks"; 
$sql.=" WHERE del=0"; 
$sql.=" ORDER BY sort ASC"; 

$c=0;
$res = mysqli_query($mysqli,$sql);
while($row = mysqli_fetch_assoc($res)){
	$tmp_id.=$row["twitter"].",";

	$dat[$c]["sort"]		=$row["sort"];
	$dat[$c]["comm"]		=$row["comm"];
	$dat[$c]["twitter"]		=$row["twitter"];
	$dat[$c]["insta"]		=$row["insta"];
	$dat[$c]["facebook"]	=$row["facebook"];
	$dat[$c]["url"]			=$row["url"];
	$dat[$c]["blog"]		=$row["blog"];
	$dat[$c]["cosp"]		=$row["cosp"];
	$dat[$c]["github"]		=$row["github"];
	$c++;
}
$tmp_id=substr($tmp_id,0,-1);
	$request_url = 'https://api.twitter.com/1.1/users/lookup.json';
	$request_method = 'GET' ;
	$params01 = array(
		"user_id" => "{$tmp_id}",
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
	if($dat[$n]["sort"]>90){
		$dat[$n]["name"]=$obj[$n]->name;

	}else{
		$dat[$n]["name"]=$obj[$n]->name."様";
	}
	$dat[$n]["img"]=str_replace("_normal","",$obj[$n]->profile_image_url_https);
	$dat[$n]["screen_name"]=$obj[$n]->screen_name;

}
?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
<link rel="stylesheet" href="./css/set_icon.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/first.css?_<?=date("YmdHi")?>">
<script src="./js/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
</script>
<style>
.thanks_top{
	display		:inline-block;
	width		:90vw;
	padding		:2vw;
	margin		:2vw auto;
	border		:0.5vw solid #f17766;
	box-shadow	:0.5vw 0.5vw 0.5vw rgba(60,60,60,0.5);
	color		:#606060;
	font-size	:3.6vw;
	background	:#fafaff;
	text-align	:left;
}

.thanks_box_name{
	position	:absolute;
	top			:1vw;
	left		:1vw;
	font-size	:4.5vw;
	height		:9vw;
	line-height	:9vw;
	border-bottom:0.5vw solid #000080;
	color		:#fafafa;
	text-shadow:1px 1px 0px #000080;
	font-weight	:600;
	text-align	:left;
	background	:rgba(40,60,250,0.8);
	padding-left:3vw;
	width		:91vw;
}

.thanks_box_link{
	position	:absolute;
	bottom		:0.5vw;
	right		:1vw;
	text-align	:right;
}

.thanks_box_comm{
	position	:absolute;
	top			:11vw;
	left		:27.5vw;

	display		:inline-block;
	width		:67vw;
	height		:23vw;

	font-size	:3.4vw;
	line-height	:6vw;
	color		:#404040;
	text-align	:left;
}

.thanks_box_img{
	position	:absolute;
	bottom		:2vw;
	left		:2.5vw;
	width		:20vw;
	height		:20vw;
	color		:#303030;
	box-shadow	:1px 1px 1px rgba(60,60,60,0.5);
}

.thanks_box{
	position	:relative;
	display		:inline-block;
	margin		:2vw auto;
	height		:36vw;
	width		:96vw;
	border		:0.5vw solid #f17766;
	background	:linear-gradient(to right, #f17766 26vw, #f0f0ff 26vw 100%);
}

.thanks_icon{
	display		:inline-block;
	margin		:0.5vw;
	width		:8vw;
	height		:8vw;	
	line-height	:8vw;
	text-align	:center;
	border-radius:50%;
}

.thanks_icon_in{
	display		:inline-block;
	width		:6vw;
	height		:6vw;	
	line-height	:6vw;
	font-size	:6vw;
	text-align	:center;
	color		:#fafafa;
	font-family	:at_icon;
	text-decoration:none;
	margin:1vw;
}


.p_twitter{
	border:0.5vw solid #55ACEE;
	background:linear-gradient(#70b0ff,#55ACEE);
}

.p_insta{
	border:0.5vw solid #ff7f50;
	background:linear-gradient(#ff7f50,#ff9060);
}

.p_cosp{
	border:0.5vw solid #ff0000;
	background:linear-gradient(#ff9090,#ff0000);
}

.p_url{
	border:0.5vw solid #008000;
	background:linear-gradient(#40c050,#00a000);
}

.p_fb{
	border:0.5vw solid #3D5A99;
	background:linear-gradient(#5972A7,#3D5A99);
}

.p_photo{
	border:0.5vw solid #c000c0;
	background:linear-gradient(#e060e0,#c000c0);
}
.p_github{
	border:0.5vw solid #666666;
	background:linear-gradient(#999999,#666666);
}
</style>
</head>
<body class="body">
<div class="pc_only">
	<img src="./img/top.png" style="width:700px;"><br>
	<div class="pc_box" style="font-size:14px;">
		こちらはスマホ専用サイトです。<br>
		PC・タブレットではご利用いただけません。<br>
	</div>
</div>
<div class="main_irr sp_only">
<a href="./index.php" class="irr_top">写真名刺作成サイト★OnlyMe</a>
<H1 class="h1_irr"><span class="h1_title">Special Thanks</span></h1>
<div class="thanks_top">
	OnlyMe作成にあたり、ご協力いただいた方々です。<br>
</div>
<?for($a1=0;$a1<count($dat);$a1++){?>
<div class="thanks_box">
	<span class="thanks_box_name"><?=$dat[$a1]["name"]?></span>
	<img src="<?=$dat[$a1]["img"]?>" class="thanks_box_img">
	<span class="thanks_box_comm"><?=$dat[$a1]["comm"]?></span>
	<span class="thanks_box_link">
		<?if($dat[$a1]["url"]){?><span class="thanks_icon p_url"><a href="<?=$dat[$a1]["url"]?>" class="thanks_icon_in"></a></span><?}?>
		<?if($dat[$a1]["screen_name"]){?><span class="thanks_icon p_twitter"><a href="https://twitter.com/<?=$dat[$a1]["screen_name"]?>" class="thanks_icon_in"></a></span><?}?>
		<?if($dat[$a1]["insta"]){?><span class="thanks_icon p_insta"><a href="https://instagram.com/<?=$dat[$a1]["insta"]?>" class="thanks_icon_in"></a></span><?}?>
		<?if($dat[$a1]["facebook"]){?><span class="thanks_icon p_facebook"><a href="https://facebook.com/<?=$dat[$a1]["facebook"]?>" class="thanks_icon_in"></a></span><?}?>
		<?if($dat[$a1]["blog"]){?><span class="thanks_icon p_blog"><a href="<?=$dat[$a1]["blog"]?>" class="thanks_icon_in"></a></span><?}?>
		<?if($dat[$a1]["photo"]){?><span class="thanks_icon p_photo"><a href="<?=$dat[$a1]["photo"]?>" class="thanks_icon_in"></a></span><?}?>
		<?if($dat[$a1]["cosp"]){?><span class="thanks_icon p_cosp"><a href="https://sp.cosp.jp/prof.aspx?id=<?=$dat[$a1]["cosp"]?>" class="thanks_icon_in"></a></span><?}?>
		<?if($dat[$a1]["github"]){?><span class="thanks_icon p_github"><a href="https://github.com/<?=$dat[$a1]["github"]?>" class="thanks_icon_in"></a></span><?}?>
	</span>
</div>
<?}?>
<?include_once("./x_foot.php")?>
</body>
</html>
