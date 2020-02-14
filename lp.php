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
<link rel="stylesheet" href="./css/index.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/onlyme.css?_<?=date("YmdHi")?>">

<script src="./js/jquery-3.4.1.min.js"></script>
<script src="./js/jquery-ui.min.js" defer></script>
<script src="./js/jquery.ui.touch-punch.min.js" defer></script>
<script src="./js/first.js?_<?=date("YmdHi")?>" defer></script>
<script src="./js/index.js?_<?=date("YmdHi")?>" defer></script>
<script>
$(function(){ 
	var Tmp_1=$('#beacon').offset().top;
	var Tmp_2=Tmp_1+$(window).width() * 24 /100;
	var Tmp_3=Tmp_2+$(window).width() * 35 /100;
	var Tmp_4=Tmp_3+$(window).width() * 24 /100;
	var Tmp_5=Tmp_4+$(window).width() * 35 /100;
	var Tmp_6=Tmp_5+$(window).width() * 24 /100;
	var Tmp_7=Tmp_6+$(window).width() * 35 /100;
	var Tmp_8=Tmp_7+$(window).width() * 24 /100;

	console.log("▲"+Tmp_1);
	console.log("▲"+Tmp_2);
	console.log("▲"+Tmp_3);
	console.log("▲"+Tmp_4);
	console.log("▲"+Tmp_5);
	console.log("▲"+Tmp_6);
	console.log("▲"+Tmp_7);
	console.log("▲"+Tmp_8);

	$(window).scroll(function () {
	console.log("●"+$(this).scrollTop());

		if ($(this).scrollTop() >Tmp_1 && $('#tl1').css('display') == 'none') {
			$('#tl1').show().animate({'top':'2vw'},200).animate({'top':'4vw'},200);
		}

		if ($(this).scrollTop() >Tmp_2 && $('#tl2').css('display') == 'none') {
			$('#tl2').show().animate({'top':'26vw'},200).animate({'top':'28vw'},200);
		}

		if ($(this).scrollTop() >Tmp_3 && $('#tl3').css('display') == 'none') {
			$('#tl3').show().animate({'top':'65vw'},200).animate({'top':'67vw'},200);
		}

		if ($(this).scrollTop() >Tmp_4 && $('#tl4').css('display') == 'none') {
			$('#tl4').show().animate({'top':'89vw'},200).animate({'top':'91vw'},200);
		}

		if ($(this).scrollTop() >Tmp_5 && $('#tl5').css('display') == 'none') {
			$('#tl5').show().animate({'top':'128vw'},200).animate({'top':'130vw'},200);
		}

		if ($(this).scrollTop() >Tmp_6 && $('#tl6').css('display') == 'none') {
			$('#tl6').show().animate({'top':'152vw'},200).animate({'top':'154vw'},200);
		}

		if ($(this).scrollTop() >Tmp_7 && $('#tl7').css('display') == 'none') {
			$('#tl7').show().animate({'top':'191vw'},200).animate({'top':'193vw'},200);
		}

		if ($(this).scrollTop() >Tmp_8 && $('#tl8').css('display') == 'none') {
			$('#tl8').show().animate({'top':'215vw'},200).animate({'top':'217vw'},200);
		}
	});
});

</script>
</head>
<body class="body">
<div>
<H1 class="h1"><span class="h1_title">写真名刺作成サイト★OnlyMe</span></h1>
<div class="top_img">
	<img src="./img/top.png" style="width:100%;" alt="onlyme_top">
	<div class="top_login">
		<form id="user_login" action="./index.php" method="post">
			<input type="text" name="log_in" placeholder="ID or ADDRESS" class="top_input"><br>
			<input type="password" name="log_pass" placeholder="PASSWORD" class="top_input"><br>
			<span class="btn_login">LOGIN</span>
		</form>
	</div>
</div>

<div class="top_msg">
	スマホで作成<br>
	コンビニで印刷<br>
	手軽で簡単な写真名刺制作サイトです<br>
	<span class="err_msg"><?=$msg?></span>
</div>

<div id="beacon" style="height:80vh;background:#fafafa"></div>

<div class="tl_box">
<div id="tl1" class="flex_q">
<div class="q1"><img src="./img/lp/lp_q1.png" class="tl_face"></div>
<div class="q2"><span class="q4">▲</span></div>
<div class="q3">パソコン持っていない。あっても難しいソフトは使えない</div>
</div>

<div id="tl2" class="flex_a">
<div class="a1"><img src="./img/lp/lp_a2.png" class="tl_face"></div>
<div class="a2"><span class="a4">▲</span></div>
<div class="a3">名刺データはスマホから作成でき、操作もとても簡単です。簡単な画像調整も可能ですので、パソコンや難しい知識は全く必要はありません。<br></div>
</div>

<div id="tl3" class="flex_q">
<div class="q1"><img src="./img/lp/lp_q1.png" class="tl_face"></div>
<div class="q2"><span class="q4">▲</span></div>
<div class="q3">印刷所に頼むと時間がかかる。自宅に送られてくるのも嫌</div>
</div>

<div id="tl4" class="flex_a">
<div class="a1"><img src="./img/lp/lp_a2.png" class="tl_face"></div>
<div class="a2"><span class="a4">▲</span></div>
<div class="a3">作成された名刺データは、そのままコンビニのマルチコピー機でプリントできますので、印刷所から送られてくることもありません。もちろん住所登録も必要ありません。<br></div>
</div>

<div id="tl5" class="flex_q">
<div class="q1"><img src="./img/lp/lp_q2.png" class="tl_face"></div>
<div class="q2"><span class="q4">▲</span></div>
<div class="q3">衣装毎に作りたいので少ない枚数で安く、それでいて高品質の物を作りたい</div>
</div>

<div id="tl6" class="flex_a">
<div class="a1"><img src="./img/lp/lp_a2.png" class="tl_face"></div>
<div class="a2"><span class="a4">▲</span></div>
<div class="a3">プリントは3枚80円。用紙は写真用の厚手光沢紙が使われます。<br>データの作成は無料ですので、複数デザインすることも可能です。<br></div>
</div>

<div id="tl7" class="flex_q">
<div class="q1"><img src="./img/lp/lp_q3.png" class="tl_face"></div>
<div class="q2"><span class="q4">▲</span></div>
<div class="q3">宅コスレイヤーなので、名刺を渡す相手がいないです（泣）</div>
</div>

<div id="tl8" class="flex_a">
<div class="a1"><img src="./img/lp/lp_a1.png" class="tl_face"></div>
<div class="a2"><span class="a4">▲</span></div>
<div class="a3">他の人の名刺を見ることができ、自分の名刺も見てもらえます。<br>評価もつけられますので、素敵な縁が生まれるかもしれません。<br></div>
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
<br>
<div class="sns_box">
<a href="https://twitter.com/onlyme_staff" class="link_twitter"></a>
<a href="https://instagram.com/onlyme_staff" class="link_insta"></a>
<a href="./outpost.php" class="link_mail"></a>
</div>


<div class="ft_box">
<a href="policy.php" class="ft"><span class="ft_ar icon_img"></span><span class="ft_txt">プライバシーポリシー</span></a>
<a href="kiyaku.php" class="ft"><span class="ft_ar icon_img"></span><span class="ft_txt">利用規約</span></a>
<a href="outpost.php" class="ft"><span class="ft_ar icon_img"></span><span class="ft_txt">お問い合わせ・ご意見</span></a>
</div>
<div style="height:4vh">　</div>
<?include_once("./x_foot.php")?>
