<?
/*
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/no_session.php");
include_once("./library/lib_regist.php");


https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=1653949496&redirect_uri=https%3a%2f%2fonlyme.fun%2fline_login.php&state=1sdf&scope=openid

*/

$dat_e = array(
  'grant_type'    => 'authorization_code',
  'code'          => $_GET['code'],
  'redirect_uri'  => 'https%3A%2F%2Fonlyme.fun%2Fline_login.php',
  'client_id'     => '1653949496',
  'client_secret' => '8602dc9eba8e1901830af09a045f0711'
);

$url = "https://api.line.me/oauth2/v2.1/token";

$content = http_build_query($dat_e);
$dat_e2 = array(
	'http' => array(
		'header' =>"Content-Type: application/x-www-form-urlencoded",
		'method' =>'POST',
		'content'=>$content
	)
);

$e_token = file_get_contents($url,false, stream_context_create($dat_e2));
$e_login =json_decode($e_token,true);


//$accessToken = $e_token->access_token;

var_dump($e_login);
echo '<hr>';
print($url);
echo '<hr>';
var_dump($dat_e2);
echo '<hr>';



?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
<link rel="stylesheet" href="./css/set_icon.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/first.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/regist.css?_<?=date("YmdHi")?>">

<script src="./js/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
</script>
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
<h1 class="h1_irr"><span class="h1_title">LINEログイン</span></h1>


</div>
<?include_once("./x_foot.php")?>
</body>
</html>


