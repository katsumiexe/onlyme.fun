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

<script src="./js/jquery-3.4.1.min.js"></script>
<script src="./js/jquery-ui.min.js"></script>
<script src="./js/jquery.ui.touch-punch.min.js"></script>
<script src="./js/first.js?_<?=date("YmdHi")?>"></script>
<script src="./js/index.js?_<?=date("YmdHi")?>"></script>
<script src="./js/mydata.js?_<?=date("YmdHi")?>"></script>
<script>
$(function(){ 

</script>
<style>
.flex_q{
	display		:block;
	position	:relative;
	width		:99vw;
	height		:22vw;
	margin		:2vw auto;
	text-align	:left;	
}

.flex_a{
	display		:block;
	position	:relative;
	width		:99vw;
	height		:33vw;
	margin		:2vw auto 5vw auto;
	text-align	:right;
}

.q1{
	display		:inline-block;
	position	:absolute;
	top			:1vw;
	left		:2vw;
	width		:16vw;
	height		:16vw;
	background	:#ff6060;
	border-radius:50%;
}

.q2{
	display		:inline-block;
	position	:absolute;
	top			:5vw;
	left		:16vw;
	width		:5vw;
	height		:5vw;
	font-size	:5vw;
	color		:#8de055;
}

.q3{
	display		:inline-block;
	background	:#fafafa;
	color		:#666666;
	box-shadow	:1px 1px 0.5vw rgba(60,60,60,0.5);
	width		:65vw;
	font-size	:3.8vw;
	line-height	:6vw;
	border-radius:3vw;
	min-height	:17vw;

	margin-left	:22vw;
	padding		:2vw;
}

.q4{
	position	:absolute;
	right		:-2vw;
	font-size	:5vw;
	color		:#fafafa;
	transform	:rotate(-80deg);
}

.a1{
	display		:inline-block;
	position	:absolute;
	top			:1vw;
	right		:2vw;
	width		:16vw;
	height		:16vw;
	background	:#606060;
	border-radius:50%;
}

.a2{
	display		:inline-block;
	position	:absolute;
	top			:5vw;
	right		:16vw;
	width		:5vw;
	height		:5vw;
	color		:#fafafa;
	font-size	:5vw;
}

.a3{
	display		:inline-block;
	background	:#8de055;
	color		:#303030;
	box-shadow	:1px 1px 0.5vw rgba(60,60,60,0.5);
	width		:65vw;
	height		:30vw;
	font-size	:3.8vw;
	line-height	:6vw;
	border-radius:3vw;
	text-align	:left;
	padding		:2vw;
	margin-right:22vw;
}

.a4{
	position	:absolute;
	left		:-2vw;
	font-size	:5vw;
	color		:#8de055;
	transform	:rotate(80deg);
}

.tl_box{
	background	:#7494c0;
	height		:245vw;
}
</style>
</head>
<body class="body">
<?include_once("./x_head.php")?>
<div class="main">
<div style="height:100vh;"></div>
<div class="tl_box">

<div id="tl1" class="flex_q">
<div class="q1"></div>
<div class="q2"><span class="q4">▲</span></div>
<div class="q3">パソコン持っていない。あっても難しいソフトは使えない</div>
</div>

<div id="tl2" class="flex_a">
<div class="a1"></div>
<div class="a2"><span class="a4">▲</span></div>
<div class="a3">名刺データはスマホから作成でき、操作もとても簡単です。簡単な画像調整も可能ですので、パソコンや難しい知識は全く必要はありません。<br></div>
</div>

<div id="tl3" class="flex_q">
<div class="q1"></div>
<div class="q2"><span class="q4">▲</span></div>
<div class="q3">印刷所に頼むと時間がかかる。自宅に送られてくるのも嫌</div>
</div>

<div id="tl4" class="flex_a">
<div class="a1"></div>
<div class="a2"><span class="a4">▲</span></div>
<div class="a3">作成された名刺データは、そのままコンビニのマルチコピー機でプリントできますので、印刷所から送られてくることもありません。もちろん住所登録も必要ありません。<br></div>
</div>

<div id="tl5" class="flex_q">
<div class="q1"></div>
<div class="q2"><span class="q4">▲</span></div>
<div class="q3">衣装毎に作りたいので少ない枚数で安く、それでいて高品質の物を作りたい</div>
</div>

<div id="tl6" class="flex_a">
<div class="a1"></div>
<div class="a2"><span class="a4">▲</span></div>
<div class="a3">プリントは3枚80円。用紙は写真用の厚手光沢紙が使われます。<br>データ作成は無料ですので、複数デザインし、使い分けることも可能です。<br></div>
</div>

<div id="tl7" class="flex_q">
<div class="q1"></div>
<div class="q2"><span class="q4">▲</span></div>
<div class="q3">宅コスレイヤーなので、名刺を渡す相手がいないです（泣）</div>
</div>

<div id="tl8" class="flex_a">
<div class="a1"></div>
<div class="a2"><span class="a4">▲</span></div>
<div class="a3">サイトでみんなの名刺を見ることができ、自分の名刺も見てもらえます。<br>評価もつけられますので、素敵な縁が生まれるかもしれません。<br></div>
</div>
<br> 
</div>

名刺情報を入力
名前、作品名、SNSアカウント（Twitter／instagram／CosplayerArchive）が使えます。

テンプレートを選択

使う写真をアップロード

写真の微調整
向き、位置、サイズ、明るさを調整できます。

コンビニでプリントアウト

<?include_once("./x_foot.php")?>
</body>
</html>
