<?php
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/no_session.php");
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
<div class="pc_only">
	<img src="./img/top.png" style="width:700px;"><br>
	<div class="pc_box" style="font-size:14px;">
		こちらはスマホ専用サイトです。<br>
		PC・タブレットではご利用いただけません。<br>
	</div>
</div>
<div class="main_irr sp_only">
<a href="./index.php" class="irr_top">写真名刺作成サイト★OnlyMe</a>
<h1 class="h1_irr"><span class="h1_title">利用規約</span></h1>

<div class="policy2">
この利用規約は、「OnlyMe」（以下「僕」）がサイト上で提供するサービス（以下「これ」）の利用条件を定めるものだ。<br>
登録ユーザーの皆様（以下「君たち」）には、本規約に従ってもらうようお願いするよ。<br>
</div>

<div class="policy1">
第1条　～利用登録～
</div>
<div class="policy2">
君たちがこれを利用するには、この規約に同意してもらう必要がある。<br>
登録した時点で規約には同意したとみなすので、よく確認しておいてくれ。<br>
<br>
登録情報は、君たちのメールアドレスをベースに作成される。<br>
以下のメールアドレスは登録には使えないのでご注意を。<br>
・過去または現在、既に登録履歴のあるもの<br>
・登録者本人のものではないもの<br>
・その他、僕が不適切と判断したもの<br>
<br>
退会したアカウント、垢BANされたアカウントでの登録もできない。<br>
退会したアカウントで利用を希望されるのなら、新規登録ではなく、再開を選択してくれ。<br>
垢BANされたアカウントでの利用は……諦めてくれ。<br>
</div>

<div class="policy1">
第2条　～IDおよびパスワード～
</div>
<div class="policy2">
登録すると、僕から君たちにID番号をお渡しする。<br>
これを使うにはログインをしていただく必要があるが、ID番号はそのログインに必要となる。<br>
IDの代わりに登録時のメールアドレスを用いることもできるぞ。<br>
このID番号と、登録時に君たちが決めたパスワードは、君たちの個人情報を管理する重要なものだ。<br>
貸与、譲渡はできない。また、他人に教えたりしないよう、知られないよう気を付けてほしい。<br>
</div>

<div class="policy1">
第3条　～退会～
</div>
<div class="policy2">
君たちはいつでも退会することができる。<br>
ただし、退会したら24時間は再開することはできない。<br>
退会すると、作成に使った画像、名刺は全て僕の方で削除をする。<br>
応援、評価、フォローに関しては削除はしない。<br>
必要なら、君たちの方で退会前に削除をしてくれ。<br>
</div>

<div class="policy1">
第4条　～禁止事項～
</div>
<div class="policy2">
君たちがこれを使う際、以下の行為を禁止する<br>
公序良俗に反すること<br>
犯罪に関連する、日本の法令に違反する行為<br>
本サービス、他の会員の権利を侵害すること<br>
本サービス、又は第三者に不利益，不快感を与えると判断されること<br>
その他、僕が「それはダメだ！」と判断すること<br>
<br>
禁止事項に抵触した場合、僕は君たちに利用の制限を加える。<br>
最悪の場合は垢BANも辞さない。<br>
</div>

<div class="policy1">
第5条　～免責事項～
</div>
<div class="policy2">
僕は君たちの権利もプライバシーも全力で守護（まも）るが、それでも限界はある。<br>
当サイトを用いることで君たちに損害が生じたとしても、それには一切責任を負うことは出来ないことは了承いただきたい。<br>
また、ユーザー同士のトラブル、利用に際しての不利益等に関しては僕の方では保証いたしかねる。<br>
</div>

<div class="policy1">
第6条　～サービス内容の変更等～
</div>
<div class="policy2">
僕は君たちに連絡もなく、突然サービスを変更したり、この規約を変更することもある。<br>
</div>
</div>
<?include_once("./x_foot.php")?>
</body>
</html>
