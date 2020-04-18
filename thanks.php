<?
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/no_session.php");
/*
require_once("./library/twitteroauth/autoload.php");
use Abraham\TwitterOAuth\TwitterOAuth;

$c_key	="GzrPhtQWHEIppfuMd2ncdluDb";
$c_sec	="WY4P1sGmPauStgfuIgWWrCKqDa5bw3vcyxjRNc1uHPmHuOPhdZ";
$s_tok	="1145915557620768768-MVV335sWkO88NVed1dBuUBw2veDm7v";	
$s_sec	="DrgnDGj7JN1MdzBPNxepqwq97ECpELdWfDB1QsGVs6Xq5";

$obj = new TwitterOAuth($c_key, $c_sec, $s_tok, $s_sec); 

$sql ="SELECT * FROM me_thanks";
$sql .=" WHERE del=0";
$sql .=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($dat2 = mysqli_fetch_assoc($result)){
		$thanks[$dat2["sort"]]=$dat2;
	}
}
*/
/*https://syncer.jp/Web/API/Twitter/REST_API/GET/users/lookup/*/
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
	top			:1vw;
	right		:1vw;
	text-align	:right;
}

.thanks_box_comm{
	position	:absolute;
	top			:11vw;
	left		:27.5vw;
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
	margin		:1vw;
	width		:6vw;
	height		:6vw;	
	line-height	:6vw;
	font-size	:4.5vw;
	text-align	:center;
	color		:#fafafa;
	font-family	:at_icon;
	text-decoration:none;
	border-radius:50%;
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

<div class="thanks_icon" style="color:#303030"></div>
<?foreach($thanks as $a1 =>$a2){?>
<div class="thanks_box">
	<span class="thanks_box_name"><?=$thanks[$a1]["name"]?></span>
	<span class="thanks_box_link">
		<?if($thanks[$a1]["url"]){?><a href="<?=$thanks[$a1]["url"]?>" class="thanks_icon p_url"></a><?}?>
		<?if($thanks[$a1]["twitter"]){?><a href="https://twitter.com/<?=$thanks[$a1]["twitter"]?>" class="thanks_icon p_twitter"></a><?}?>
		<?if($thanks[$a1]["insta"]){?><a href="https://instagram.com/<?=$thanks[$a1]["insta"]?>" class="thanks_icon p_insta"></a><?}?>
		<?if($thanks[$a1]["facebook"]){?><a href="https://facebook.com/<?=$thanks[$a1]["facebook"]?>" class="thanks_icon p_facebook"></a><?}?>
		<?if($thanks[$a1]["blog"]){?><a href="<?=$thanks[$a1]["blog"]?>" class="thanks_icon p_blog"></a><?}?>
		<?if($thanks[$a1]["photo"]){?><a href="<?=$thanks[$a1]["photo"]?>" class="thanks_icon p_photo"></a><?}?>
		<?if($thanks[$a1]["cosp"]){?><a href="https://sp.cosp.jp/prof.aspx?id=<?=$thanks[$a1]["cosp"]?>" class="thanks_icon p_cosp"></a><?}?>
		<?if($thanks[$a1]["github"]){?><a href="https://github.com/<?=$thanks[$a1]["github"]?>" class="thanks_icon p_github"></a><?}?>
	</span>
	<img src="<?=$thanks[$a1]["img"]?>" class="thanks_box_img">
	<span class="thanks_box_comm"><?=$thanks[$a1]["comm"]?></span>
</div>
<?}?>
<?include_once("./x_foot.php")?>
</body>
</html>
