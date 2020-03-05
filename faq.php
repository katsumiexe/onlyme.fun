<?php
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/no_session.php");
$nowpage=3;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<title>写真名刺制作サイト「OnlyMe」:how_to_use:1</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
<meta name="description" content="使い方説明1：PC不要、住所不要、スマホで作成、コンビニで印刷。手軽で簡単な写真名刺制作サイトです。">
<meta name="keywords" content="写真名刺,コスプレ,onlyme,名刺作成,無料">
<meta name="robots" content="noindex">

<link rel="stylesheet" href="./css/set_icon.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/first.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/note.css?_<?=date("YmdHi")?>">

</head>
<body class="body">
<?include_once("./x_irr.php")?>
<div class="main">
<h1 class="h1"><span class="h1_title">簡単名刺の作成</span></h1>

<h2 class="h2">無料なの？</h2>
<div class="exp_box1">
登録、制作は完全無料です。データ出力時にコピー代として80円かかります<br>
</div>
<br>

<h2 class="h2">使う用紙はペラい普通紙なの？</h2>
<div class="exp_box1">
用紙は厚手の光沢紙が使われます。<br>
</div>
<br>
<h2 class="h2">名刺の形式と1回で印刷できる枚数は？</h2>
<div class="exp_box1">
フォーマットは縦型横書きで、サイズは91㎜×55㎜です。<br>
一度の印刷で3枚分出力されます。
</div>
<br>
<h2 class="h2">切るのは自分ですよね。。。</h2>
<div class="exp_box1">
はい。。。。すみませんがそこは頑張ってください。<br>
</div>
<br>
<h2 class="h2">どんなデータを載せられるの？</h2>
<div class="exp_box1">
・名前<br>
・作品名<br>
・twitterID<br>
・instagramID<br>
・コスプレイヤーアーカイブID<br>
です。
</div>
<br>
<h2 class="h2">写真加工はどれくらいできるの？</h2>
<div class="exp_box1">
・位置調整<br>
・拡大、縮小<br>
・回転<br>
・反転<br>
・明暗調整<br>
・グレースケール/セピア<br>
です。
</div>
<br>
<h2 class="h2">フルスクラッチで作れないの？</h2>
<div class="exp_box1">
ゆくゆくはフリーデザインや、ユーザーでデザインのテンプレートの登録をできる仕様にしたいのですが、現時点では既存のテンプレ－トをご利用いただくことになります。
</div>
<br>
<h2 class="h2">横型名刺は作れないのですか？</h2>
<div class="exp_box1">
現段階では縦型のみです。お声をいただいていますので、早い段階での開発予定はあります。<br>
</div>
<br>
<h2 class="h2">PCでは使えないのですか？</h2>
<div class="exp_box1">
他の開発案件が落ち着いたら検討しますが、現時点ではまだ予定はありません（そこまで手が回りません）。<br>
</div>
<br>
<h2 class="h2">猫耳とか鼻とかひげとかつけられたらうれしい</h2>
<div class="exp_box1">
そこまではまだ難しいですね。。。snowはすごいです。<br>
</div>
<br>
<h2 class="h2">どんな技術を使っているの？</h2>
<div class="exp_box1">
作成、加工はjQuery、最終画像出力はPHPGD、会員データ、ログの取り扱いはMySQLを用いています。
</div>
<br>
<h2 class="h2">あんたダレ？</h2>
<div class="exp_box1">
個人です。本職は池袋でSEっぽいことをしています。企業サイトではありません。
</div>
<br>
<br>
<?include_once("./x_foot.php")?>
</body>
</html>
