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
	text-align	:left;
}

.thanks_box_name{
	position	:absolute;
	top			:1vw;
	left		:1vw;
	font-size	:4vw;
	color		:#0020a0;
	font-weight	:600;
	text-align	:left;
}

.thanks_box_link{
	position	:absolute;
	top			:1vw;
	right		:1vw;
	text-align	:right;
}

.thanks_box_comm{
	position	:absolute;
	top			:8vw;
	left		:22vw;
	font-size	:4vw;
	color		:#909090;
	text-align	:left;
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
	height		:20vw;
	width		:96vw;
	border		:0.5vw solid #f17766;
	background	:linear-gradient(to right, #f17766 20%, #f0f0ff 20% 100%);
}

.thanks_twitter{
	display		:inline-block;
	margin		:1vw;
	width		:10vw;
	height		:10vw;
	line-height	:10vw;
}
</style>

</head>
<body class="body">
<div class="main_irr">
<h1 class="h1"><span class="h1_title">Spetial Thanks</span></h1>

<div class="thanks_top">
	OnlyMe作成にあたり、ご協力いただいた方々です。<br>
</div>

<?foreach($thanks as $a1 =>$a2){?>
<div class="thanks_box">
	<span class="thanks_box_name"><?=$thanks[$a1]["name"]?></span>

	<span class="thanks_box_link">
		<?if($thanks[$a1]["url"]){?><a href="<?$thanks[$a1]["url"]?>" class="thanks_url"></a><?}?>
		<?if($thanks[$a1]["twitter"]){?><a href="https://twitter.com/<?$thanks[$a1]["twitter"]?>" class="thanks_twitter"></a><?}?>
		<?if($thanks[$a1]["insta"]){?><a href="https://instagram.com/<?$thanks[$a1]["insta]?>" class="thanks_insta"></a><?}?>
		<?if($thanks[$a1]["facebook"]){?><a href="" class="thanks_facebook"></a><?}?>
		<?if($thanks[$a1]["photo"]){?><a href="" class="thanks_photo"></a><?}?>
		<?if($thanks[$a1]["cosp"]){?><a href="" class="thanks_cosp"></a><?}?>
		<?if($thanks[$a1]["github"]){?><a href="" class="thanks_github"></a><?}?>
	</span>

	<img src="<?=$thanks[$a1]["img"]?>" class="thanks_box_img">
	<span class="thanks_box_comm"><?=$thanks[$a1]["comm"]?></span>
</div>
<?}?>

<?include_once("./x_foot.php")?>
</body>
</html>
