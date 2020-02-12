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
<link rel="stylesheet" href="./css/policy.css?_<?=date("YmdHi")?>">

<script src="./js/jquery-3.2.1.min.js"></script>
<style>

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

<h1 class="h1">Privacy Policy</h1>
<div class="policy1">
ご利用規約（村上春樹テイスト）</div>
<div class="policy2">

ご利用規約は、ぴよぴよわーく（以下「僕」）が
</div>

君はユーザー登録することでサービスをご利用いただけるようになります。
登録にはメールアドレスを基にお名前、生年月日、出身都道府県、ログイン用パスワードの設定が必要です。なお、君が作成できる登録アカウントは一つだけです。複数の登録が発覚した場合、一つを除いて登録を凍結させて頂くこともございます。ご了承下さい。
登録すると会員IDが発行されます。なお、登録時の情報、および会員IDは他の人に知られないよう、管理は君の責任で行ってもらいます。



退会
退会はサイト内よりお受けしており、いつでも可能です。
退会されますと、過去のアルバムは全て削除されます。
また、退会後24時間経たないと再開することは出来ません。



</div>
<?include_once("./x_foot.php")?>
</body>
</html>
