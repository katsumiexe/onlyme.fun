<?php
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/no_session.php");
$nowpage=2;
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
</head>

<body class="body">
<?include_once("./x_irr.php")?>
<div class="main">
<h1 class="h1"><span class="h1_title">簡単名刺の作成</span></h1>
<?=file_get_contents("./note/menu_b11.php")?>
<?=file_get_contents("./note/menu_b12.php")?>
<br>
<?include_once("./x_foot.php")?>
</body>
</html>

