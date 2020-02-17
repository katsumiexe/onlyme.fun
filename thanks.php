<?
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/no_session.php");

$sql ="SELECT * FROM me_thanks";
$sql .=" WHERE del=0";
$sql .=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($dat2 = mysqli_fetch_assoc($result)){
		$thanks[$dat2["sort"]]=$dat2;
	}
}

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
	margin		:1vw auto;
	border		:0.5vw solid #f17766;
	box-shadow	:0.5vw 0.5vw 0.5vw rgba(60,60,60,0.5);
	color		:#606060;
	font-size	:3.6vw;
	background	:#fafaff;
}

.thanks_box_name{
	position	:absolute;
	top			:1vw;
	left		:1vw;
	font-size	:4vw;
	color		:#90a0ff;
	font-weight	:600;
}

.thanks_box_comm{
	position	:absolute;
	top			:8vw;
	left		:22vw;
	font-size	:4vw;
	color		:#90a0ff;
}

.thanks_box_img{
	position	:absolute;
	top			:9vw;
	left		:4.5vw;
	width		:10vw;
	height		:10vw;
	color		:#303030;
}

.thanks_box{
	position	:relative;
	display		:inline-block;
	margin		:2vw auto;
	width		:96vw;
	border		:0.5vw solid #f17766;
	background	:linear-gradient(#f17766 20vw, #f0f0ff 20vw 100%);
}
</style>

</head>
<body class="body">
<div class="main_irr">
<h1 class="h1"><span class="h1_title">Spetial Thanks</span></h1>

<div class="thanks_top">
OnlyMe作成にあたり、ご協力いただいた方々です。<br>
</div>

<div class="thanks_box">
<span class="thanks_box_name"></span>
<span class="thanks_box_comm"></span>
<img src="" class="thanks_box_img">
<span class="thanks_twitter"></span>
<span class="thanks_url"></span>
</div>

<?include_once("./x_foot.php")?>
</body>
</html>
