<?php
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/session.php");
$nowpage=1;
$ex=8;
$d=0;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>写真名刺制作サイト「OnlyMe」</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
<meta name="description" content="PC不要、住所不要、スマホで作成、コンビニで印刷。手軽で簡単な写真名刺制作サイトです。">
<meta name="keywords" content="写真名刺,コスプレ,画像修正,onlyme,名刺作成,無料,簡単">
<link rel="stylesheet" href="./css/set_icon.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/first.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/note.css?_<?=date("YmdHi")?>">

<script src="./js/jquery-3.2.1.min.js"></script>
<script src="./js/first.js"></script>
<script src="./js/note.js"></script>
<script>
</script>
</head>
<body class="body">
<?if(!$_SESSION["id"]){?>
<?include_once("./x_irr.php")?>
<?}else{?>
<?include_once("./x_head.php")?>
<?}?>
<div class="main_fix">
<h1 class="h1"><span class="h1_title">ヘルプ</span></h1>
<div class="exp_box0">
	<div id="menu_a1" class="exp_box0_a">
		名刺の作成方法
		<div class="al0">
			<span id="xmenu_b1" class="al1"></span>
			<span id="ymenu_b1" class="al2"></span>
		</div>
	</div>
	<div id="menu_b1" class="exp_box0_b">
	<span id="menu_b11" class="exp_box0_c"><span class="note_item">デザインする</span><span class="icon_img exp_box0_d"></span></span>
	<?if($user["id"] == "10002015"){?>
	<span id="menu_b42" class="exp_box0_c"><span class="note_item">印刷する</span><span class="icon_img exp_box0_d"></span></span>
	<?}else{?>
	<span id="menu_b12" class="exp_box0_c"><span class="note_item">印刷する</span><span class="icon_img exp_box0_d"></span></span>
	<?}?>
	</div>

	<div id="menu_a2" class="exp_box0_a">
		サイトの使い方
		<div class="al0">
			<span id="xmenu_b2" class="al1"></span>
			<span id="ymenu_b2" class="al2"></span>
		</div>
	</div>
	<div id="menu_b2" class="exp_box0_b">
		<span id="menu_b21" class="exp_box0_c"><span class="note_item">お知らせ</span><span class="icon_img exp_box0_d"></span></span>
		<span id="menu_b22" class="exp_box0_c"><span class="note_item">評価する</span><span class="icon_img exp_box0_d"></span></span>
		<span id="menu_b23" class="exp_box0_c"><span class="note_item">応援する</span><span class="icon_img exp_box0_d"></span></span>
		<span id="menu_b26" class="exp_box0_c"><span class="note_item">フォロー</span><span class="icon_img exp_box0_d"></span></span>
		<span id="menu_b24" class="exp_box0_c"><span class="note_item">通報する</span><span class="icon_img exp_box0_d"></span></span>
		<span id="menu_b25" class="exp_box0_c"><span class="note_item">レベルアップと経験値</span><span class="icon_img exp_box0_d"></span></span>
	</div>

	<div id="menu_a3" class="exp_box0_a">
	Config設定
		<div class="al0">
			<span id="xmenu_b3" class="al1"></span>
			<span id="ymenu_b3" class="al2"></span>
		</div>
	</div>
	<div id="menu_b3" class="exp_box0_b">
		<span id="menu_b31" class="exp_box0_c"><span class="note_item">プロフィール画像の登録</span><span class="icon_img exp_box0_d"></span></span>
		<span id="menu_b32" class="exp_box0_c"><span class="note_item">基本情報の変更</span><span class="icon_img exp_box0_d"></span></span>
		<span id="menu_b33" class="exp_box0_c"><span class="note_item">名刺内容の変更</span><span class="icon_img exp_box0_d"></span></span>
		<span id="menu_b34" class="exp_box0_c"><span class="note_item">退会・再開</span><span class="icon_img exp_box0_d"></span></span>
	</div>
</div>

<div class="ft_box">
<a href="inpolicy.php" class="ft"><span class="ft_ar icon_img"></span><span class="ft_txt">プライバシーポリシー</span></a>
<a href="inkiyaku.php" class="ft"><span class="ft_ar icon_img"></span><span class="ft_txt">利用規約(OnlyMe)</span></a>
<a href="inkiyaku_sharp.php" class="ft"><span class="ft_ar icon_img"></span><span class="ft_txt">利用規約(ネットワークプリント)</span></a>
</div>


<div class="page">
	<div class="page_top"><span class="page_back icon_img"></span><span class="page_title"></span></div>
	<div class="page_main"></div>	
</div>

<?include_once("./x_foot.php")?>
</body>
</html>