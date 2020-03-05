<?php
include_once("./library//lib.php");
include_once("./library//lib_me.php");
$nowpage=2;
$user_id=1;
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

<link rel="stylesheet" href="./font/font_01/style.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/first.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/howto.css?_<?=date("YmdHi")?>">
<script src="./js/jquery-3.2.1.min.js"></script>
</head>
<body>
<?include_once("./x_irr.php")?>
<div class="faq">FAQ</div>
<div class="box_q">使う用紙はペラい普通紙なの？</div>
<div class="box_a">
印刷はファミリーマート、ローソンのコピー機の「写真用２Lサイズ」の利用を想定しています。<br>
こちらは厚手のしっかりした光沢紙です。<br>
</div>
<div class="box_q">印刷できる名刺のサイズは？</div>
<div class="box_a">
91㎜×55㎜：3枚です。
</div>
<div class="box_q">切るのは自分ですよね。。。</div>
<div class="box_a">
はい。。。。すみませんがそこは頑張ってください。<br>
</div>
<div class="box_q">写真加工はどれくらいできるの？</div>
<div class="box_a">
明るさ調整、グレイスケール化、セピア化、あとは位置調整とかズームとか反転とかです。<br>
切り抜きとかモザイクとか高度なことは未対応です。ごめんなさい。<br>
</div>
<div class="box_q">どんなデータを載せられるの？</div>
<div class="box_a">
現時点では、名前／作品名／メールアドレス／twitterアカウント／ブログURL／コスプレイヤーアーカイブ会員IDです。<br>
LINE ID、電話番号、FACEBOOKアカウントは現在検討中です。
</div>

<div class="box_q">どんな技術を使っているの？</div>
<div class="box_a">
作成、加工はJquery、最終画像出力はPHPGD、会員データ、ログの取り扱いはMysqlを用いています。
</div>

<div class="box_q">自分でデザインはできないの？</div>
<div class="box_a">
ゆくゆくはフリーデザインや、ユーザーでデザインのテンプレ登録をできる仕様にしたいのですが、現時点では既存のテンプレをご利用いただくことになります。
</div>

<div class="box_q">あんたダレ？</div>
<div class="box_a">
個人です。本職は池袋でSEっぽいことをしています。昭和生まれのおっさんです。企業サイトではありません。
</div>
<?include_once("./x_foot.php")?>
</body>
</html>
