<?php
include_once("./library//lib.php");
include_once("./library//session.php");
$area=$_REQUEST["area"];
$pg=$_REQUEST["pg"];

if(!$pg) $pg=1;
$pg_st=($pg-1)*20;
$pg_ed=($pg-1)*20+20;

if($user["style"]==1){
	$bbs_style=2;
}else{
	$bbs_style=1;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="../css/frame.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./font/style.css?_<?=date("YmdHi")?>">
<script src="./js/jquery-3.2.1.min.js"></script>
<script>
jQuery( function($) {
	$('.sub_slide').hide();
	$('.main_slide').click(function(){
		$('div.sub_slide').fadeOut(500);
		if($('+div.sub_slide',this).css('display') == 'none'){
			$('img',this).addClass('rotate');
			$('+div.sub_slide',this).fadeIn(200);
		}
	});
});
function Del(){
	document.getElementById('log').value = "";
}

function Send(){
	if(window.confirm('送信します。\nよろしいですか')){
		window.alert('送信されました');
		return true;

	}else{
		window.alert('キャンセルされました');
		return false;

	}
}
</script>
</head>

<body>
<div class="all">
<?if(!$_SESSION){?>
<?include_once("./x_irr.php")?>
<? }else{ ?>
<?include_once("./x_head.php")?>
<div class="main">
てすと<br>
てすてす<bR>
</div>
<?include_once("./x_foot.php")?>
<? } ?>
</div>
</body>
</html>
