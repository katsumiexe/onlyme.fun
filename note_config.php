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
<link rel="stylesheet" href="./css/exp.css?_<?=date("YmdHi")?>">

<script src="./js/jquery-3.2.1.min.js"></script>
<style>
.exp_table{
	width:92vw;
	margin:1vw auto;
	border:1vw solid #f0c0d0;
}

.exp_title{
	height:5vw;
	line-height:5vw;
	border:0.2vw solid #303030;
	font-size:3.8vw;
	text-align:center;
	vertical-align:middle;
	background:#f17766;
	color:#ffffff;
	font-weight:600;
}

.exp_cnt,.exp_pts{
	width:18vw;
	padding:1vw;
}

.exp_act2{
	border:0.2vw solid #303030;
	text-align:left;
	background:#fafafa;
	height:6vw;
	line-height:6vw;
	font-size:3.8vw;
	padding:1vw;
}

.exp_cnt2,.exp_pts2{
	border:0.2vw solid #303030;
	text-align:right;
	background:#fafafa;
	font-size:3.8vw;
	padding:1vw;
}

.exp_box1{
	padding:1vw;
	background:#fff0f5;
	width:90vw;
	margin:2vw auto;
	border:1vw solid #f0c0d0;
	border-radius:2vw;
	text-align:left;
}
.exp_box2{
	padding:1vw;
	background:#fff0f5;
	width:85vw;
	margin:1vw auto;
	text-align:left;
}


.exp_msg{
	padding:0.5vw;
	color:#303030;
	background:#fafafa;
	display:inline-block;
	width:80vw;
	text-align:left;
}

.exp_lv1{
	height:16vw;
	width:24vw;
	text-align:center;
	vertical-align:middle;
	color:#ffffff;
	background:#0000d0;
	font-weight:800;
	font-size:5vw;
}

.exp_com{
	height:12vw;
	line-height:6vw;
	color:#606060;
	background:#fafafa;
	font-size:3vw;
	padding:1vw;
	text-align:left;
}
</style>

</head>
<body class="body">
<?if(!$_SESSION["id"]){?>
<?include_once("./x_irr.php")?>
<div class="main2">
<?}else{?>
<?include_once("./x_head.php")?>
<div class="main">
<?}?>

<h1 class="h1"><span class="h1_title">レベルアップと経験値</span></h1>
<h2 class="h2">プロフィール画像の登録</h2>
<div class="exp_box1">
    プロフィール画像を最大3枚まで登録しておくことが可能です。<br>
    プロフィール画像を登録していますと、毎日のログイン経験値が2倍になります。<br>
    変更、削除もこちらから行えます<br>
</div>

<h2 class="h2">基本情報の変更</h2>
<div class="exp_box1">
    登録名、メールアドレス、ログインパスワード、出身地を変更ができます。<br>
    メールアドレスは50字以内のものをご利用いただけます。<br>
    パスワードは半角英数字で、50文字魔で使えます。<br>
    基本情報を変更されますとログアウトされてしまいます。<br>
    その後、登録したメールアドレスに送られてくるログイン用URLからクリック確認後、情報が変更されます。<br>
    1時間の間にログインが確認できませんと、変更処理は破棄されます。<br>
    会員ID、性別、生年月日は変更できません。<br>
</div>

<h2 class="h2">テンプレートの設定</h2>
<div class="exp_box1">
QRコード<br>
	レベル2以上で変更できるようになります。<br>
	OnlyMe以外、各SNSへのリンク、もしくは「表示しない」を設定できるようになります<br>

</div>

<div class="exp_box1">
ハンドル<br>
	10字まで。登録名とは別のものも使えます。<br>
	特殊記号、絵文字は使えないものもあります。<br>

</div>

<div class="exp_box1">
作品名<br>
	15字まで。<br>
    こちらも特殊記号、絵文字は使えないものもあります。<br>
</div>

<div class="exp_box1">
twitter/instagram/cosplayer archive<br>
	各種SNSへのIDを登録できます。<br>
	右側のスイッチをonにすると、プロフィールページで表示されるようになります。<br>
</div>

<div class="exp_box1">
退会<br>
	退会は「Config]よりいつでも行えます。<br>
	退会しますと、全てサービスをご利用いただけなくなります。<br>
	投稿した名刺、プロフィール写真は全て削除されます。<br>
	応援、評価は削除されません。<br>
    </div>

<div class="exp_box1">
再開<br>
	退会から24時間以上経過後、再開することも可能です。<br>
	再開されますと、同様にすべてのサービスをご利用いただけます。<br>
	削除された写真は復活できません。<br>
	経験値、レベル、フォロー、フォロワーは退会前のものを継続します。<br>
</div>

<?include_once("./x_foot.php")?>
</body>
</html>