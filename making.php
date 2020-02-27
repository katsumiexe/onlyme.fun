<?php
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/session.php");
if(!$_SESSION["id"]){
	$url = 'https://onlyme.fun/index.php';
	header('Location: ' . $url, true, 301);
	exit;
}
$nowpage=3;

$cnt0=0;
$cnt1=0;
$cnt2=0;
$cnt3=0;
$cnt4=0;
$cnt5=0;
$cnt6=0;
$cnt7=0;

$pg=1;
$cnt=0;
$sql ="SELECT tmpl_id FROM me_tmpl";
$sql.=" WHERE del<>1";
$sql.=" ORDER BY tmpl_id DESC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		if($cnt<8){
			$tmpl_id[$cnt]=$row["tmpl_id"];
			$list_n["l"].="<div id=\"p{$tmpl_id[$cnt]}\" class=\"fsample\"><img src=\"./img/sample/s{$tmpl_id[$cnt]}.jpg\" class=\"fsample_img {$img_off}\"></div>";
			$img_off="img_off";


			$sql ="SELECT COUNT(making_id) as cnt, use_tmpl FROM me_making";
			$sql .=" WHERE use_tmpl='{$tmpl_id[$cnt]}'";
			$sql .=" LIMIT 1";

			if($res2 = mysqli_query($mysqli,$sql)){
				$dat2 = mysqli_fetch_assoc($res2);
				$list_n["l"].="<input id=\"cnt{$tmpl_id[$cnt]}\" type=\"hidden\" name=\"cnt\" value=\"{$dat2["cnt"]}\">";
			}
		}
		$cnt++;
	}
}

$list_n["p"]="<span class=\"card_box_n card_prev\"></span>";
$list_n["n"].="<span id=\"pg_n2\" class=\"card_box card_next\"></span>";

$pg_cnt=ceil($cnt/8);
$nn="it";
for($n=1;$n<$pg_cnt+1;$n++){
	$list_n["c"].="<span id=\"pg_c{$n}\" class=\"card_pg card_box {$nn}\">{$n}</span>";
	$nn="";
}

$tmp_url=time()+$_SESSION["id"];
for($n=0;$n<5;$n++){
	$img_url1.=$enc[substr($tmp_url,$n*2,2)];
	$img_url2.=$enc[substr($tmp_url+123456,$n*2,2)];
}
$img_url1.=".jpg";
$img_url2.=".jpg";

if($prof["qr"] ==0) $prof["qr"]=1;

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<title>写真名刺制作サイト「OnlyMe」:making-1</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
<meta name="description" content="トライアルその１：PC不要、住所不要、スマホで作成、コンビニで印刷。手軽で簡単な写真名刺制作サイトです。">
<meta name="keywords" content="写真名刺,コスプレ,onlyme,名刺作成,無料">

<link rel="stylesheet" href="./css/set_icon.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/first.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/making.css?_<?=date("YmdHi")?>">

<script src="./js/jquery-3.4.1.min.js"></script>
<script src="./js/jquery.exif.js"></script>
<script src="./js/first.js"></script>

<script>
var VwBase =$(window).width()/100;
$('#vw_set').val(VwBase);

var Zoom 	= 100;
var Top 	= 0;
var Left 	= 0;
var Rote2 	= 0;
var new_w 	= 270;
var new_h 	= 270;
var pad_w 	= 0;
var pad_h 	= 0;

var mid_w 	= 0;
var mid_h 	= 0;

var Quality	= <?=$quality[$prof["quality"]+0]?>;
var orientation=0;
var Pg 	= 0;
var data	= {};
var CvImg	= '';
var Rote	= '';

var Clr1=0;
var Clr2=1;

$(function(){ 
	$('#p<?=$tmpl_id[0]?>').css({'border-color':'#ee0000'});
	<?if($exp>=100){?>
	var Tmp=$('#qr<?=$prof["qr"]?>').html();
	$('#qr_select').html(Tmp);
	<?}?>

	$('#fol1').addClass("fol_set");
	$('#qr_option').hide();

	$('.fitem').on('click',function(){
		$('.fitem').css({'color':'#ffffff','background':'#d0d0d0'});
		$(this).css({'color':'#ffffff','background':'#008000'});
		Clr1 = $(this).attr('id').replace("v", "");
		Clr2=1;
		$('.fbox1a').hide();
		$.post({
			url:'post_read_tmpl.php',
			data:{'pg':Clr2,'cate':Clr1},
			dataType: 'json',

		}).done(function(data){
			$('.fbox1a').html(data.l).fadeIn(400);
			$('.fbox1a_page').html(data.p + data.c + data.n);

			Clr4=$('#tmpl').val();
			$('#p'+Clr4).css({'border-color':'#ee0000'}).children('img').removeClass('img_off');
		});
	});

	$(document).on('click','.card_box',function(){
	Clr2 = $(this).attr('id').replace('pg_n','').replace('pg_p','').replace('pg_c','');
		$('.fbox1a').hide();
		$.post({
			url:'post_read_tmpl.php',
			data:{'pg':Clr2,'cate':Clr1},
			dataType: 'json',

		}).done(function(data){
			$('.fbox1a').html(data.l).fadeIn(500);
			$('.fbox1a_page').html(data.p + data.c + data.n);

			Clr4=$('#tmpl').val();
			$('#p'+Clr4).css({'border-color':'#ee0000'}).children('img').removeClass('img_off');
		});
	});


	$('.fbox1a').on('click','.fsample',function(){
		Clr3 = $(this).attr('id').replace("p", "");
		Clr3_img = $(this).children('img').attr('src');

		Clr3_cnt = $('#cnt'+Clr3).val();
		console.log(Clr3_cnt);
		$('.fsample_md').animate({'top':'9vh'},100);
		$('.fsample_bk').show;

		$('.fsample_md_img').attr('src',Clr3_img);
	});

	$('.fsample_ok').on('click',function(){
		$('#tmpl').val(Clr3);
		$('.fsample').css({'border-color':'#f5f5f5'});
		$('#p'+Clr3).css({'border-color':'#d00000'});
		$('.fsample_img').addClass('img_off');
		$('#p'+Clr3).children('img').removeClass('img_off');
	
		$('.fsample_md').animate({'top':'-100vh'},100);
		$('.fsample_bk').hide;
	});

	$('.fsample_ng').on('click',function(){
		$('.fsample_md').animate({'top':'-100vh'},100);
		$('.fsample_bk').hide;
	});


	$('.fsample_if').on('click',function(){
		if($('.fsample_if').hasClass("if_on")){
			$('.fsample_if').removeClass("if_on");

			$('.fsample_md_com').animate({'height':'0vw'},100);

		}else{
			$('.fsample_if').addClass("if_on");
			$('.fsample_md_com').animate({'height':'90vw'},100);
		}
	});

	$('#fol1').on('click',function(){
		$('.folder_all1').fadeIn(100);
		$('.folder_all2,.folder_all3').hide();
		$('#fol1').addClass("fol_set");
		$('#fol2,#fol3').removeClass("fol_set");

		$('#c_on1').text("");
		$('#c_on2,#c_on3').text("");
	});

	$('#fol2').on('click',function(){
		$('.folder_all2').fadeIn(100);
		$('.folder_all1,.folder_all3').hide();
		$('#fol2').addClass('fol_set');
		$('#fol1,#fol3').removeClass('fol_set');
		$('#c_on2').text("");
		$('#c_on1,#c_on3').text("");
	});

	$('#fol3').on('click',function(){
		$('.folder_all3').fadeIn(100);
		$('.folder_all1,.folder_all2').hide();
		$('#fol3').addClass('fol_set');
		$('#fol2,#fol1').removeClass('fol_set');
		$('#c_on3').text("");
		$('#c_on1,#c_on2').text("");
	});

	$('#upd').on('change', function(e){
		var file = e.target.files[0];
		var reader = new FileReader();

		//画像でない場合は処理終了
		if(file.type.indexOf("image") < 0){
			return false;
		}
		var img = new Image();

		//2Dコンテキストのオブジェクトを生成する
		var cvs = document.getElementById('cvs1');
		var ctx = cvs.getContext('2d');

		$('#upd').fileExif(function(exif) {
			if (exif['Orientation']) {

//				Rote2=exif['Orientation'];
				switch (exif['Orientation']) {

				case 3:
					Rote = 180;
					Rote2 = 180;
					$('#view').css({
						'transform':'rotate(180deg)',
					});
					break;

				case 6:
					Rote2 = 270;
					break;

				case 8:
					Rote = 90;
					Rote2 = 90;
					$('#view').css({
						'transform':'rotate(90deg)',
					});
					break;
				}
			}
			$('#rote_ck').html(Rote+"□"+Rote2);
		});

		reader.onload = (function(file){
			return function(e){
				img.src = e.target.result;
				$("#view").attr("src", e.target.result);
				$("#view").attr("title", file.name);

				img.onload = function() {
					img_W=img.width;
					img_H=img.height;

/*
					if(img_W > img_H && img_W > Quality){
						img_W3=Quality;
						img_H3=img_H*(Quality/ img_W);
					}else if(img_H > img_W && img_H >Quality){
						img_H3=Quality;
						img_W3=img_W*(Quality/img_H);
					}else {
						img_H3=img_H;
						img_W3=img_W;
					}				
*/
					if(img_H > Quality){
						img_H3=Quality;
						img_W3=img_W*(Quality/img_H);

					}else {
						img_H3=img_H;
						img_W3=img_W;
					}				

					img_W	=Math.floor(img_W);
					img_H	=Math.floor(img_H);
					img_W3	=Math.floor(img_W3);
					img_H3	=Math.floor(img_H3);

					$("#cvs1").attr('width', img_W3);
					$("#cvs1").attr('height', img_H3);
					ctx.drawImage(img, 0, 0,img_W3,img_H3);
					CvImg = cvs.toDataURL("image/jpeg");
				}
			};
		})(file);
		reader.readAsDataURL(file);
	});
	$(".mk_lv5").on("click",function(){
		if ($('#ck_name').val() == '') {
			$('#err').stop(false,false).fadeIn(200).delay(1000).fadeOut(1000).text('「名前」は必須です');
			return false;

		}else if ($('#upd').val() == '') {
			$('#err').stop(false,false).fadeIn(200).delay(1000).fadeOut(1000).text('画像の登録がありません');
			return false;

		} else {
			$('#wait').show();
			data.cvimg	= CvImg.replace(/^data:image\/jpeg;base64,/, "");
			data.url1	= '<?=$dir?>';
			data.url2	= '<?=$img_url1?>';
			data.rote	= Rote;
			data.rote2	= Rote2;

			$.ajax({
				url: "post_making_cv.php",
				type: "POST",
				data: data,
				cache: false,
				dataType: "json"

			}).always(function( data) {
				console.log(data);
				$('#forms').submit();
			});
		}
	});

	$('.img_rote').click(function(){
		$({deg:Rote}).animate({deg:-90 + Rote}, {
			duration:500,
			progress:function() {
				$('#view').css({
					'transform':'rotate(' + this.deg + 'deg)',
				});
			},
		});

		Rote -=90;
		if(Rote <0){
			Rote+=360;
		}
	});

	$('#qr_select,.item2_box_d').on('click',function(){
		$('#qr_option').slideUp(150);
		if($('#qr_option').css('display') == 'none'){
			$('#qr_option').slideDown(150);
		}
	});

	$('.qr_option_a').on('click',function(){
		Clr2 =$(this).attr('id').replace("qr", "");
		Clr1 =$(this).html();
		$('#qr_select').html(Clr1);
		$('#qr').val(Clr2);
		$('#qr_option').slideUp(150);
	});
});

</script>
<style>
</style>
</head>
<body class="body">
<?include_once("./x_head.php")?>
<div class="main_fix">
<div id="err"></div>
<div id="wait"><span id="wait_in"></span></div>
<form id="forms" action="./making_mk.php" enctype="multipart/form-data" method="post">
<input id="tmpl" type="hidden" name="tmpl" value="<?=$tmpl_id[0]?>">
<input type="hidden" id="rote" name="rote" value="0">
<input type="hidden" name="img_url1" value="<?=$img_url1?>">
<input type="hidden" name="img_url2" value="<?=$img_url2?>">
<input type="hidden" id="vw_set" name="vw_set" value="">
<div class="mk_lv"><div id="fol1" class="mk_lv1">
	<span id="c_on1" class="icon_img mk_icon"></span>
	<span class="mk_com">デザイン</span>
</div><!--
--><div class="mk_lv4 icon_img"></div><!--
--><div id="fol2" class="mk_lv2">
	<span id="c_on2" class="icon_img mk_icon"></span>
	<span class="mk_com">画像選択</span>
</div><!--
--><div class="mk_lv4 icon_img"></div><!--
--><div id="fol3" class="mk_lv3">
	<span id="c_on3" class="icon_img mk_icon"></span>
	<span class="mk_com">テキスト</span>
</div><!--
--><div class="mk_lv4 icon_img"></div><!--
--><div class="mk_lv5 icon_img"></div></div>
<div class="folder_all1">
	<div class="fbox1"><!--
	--><div id="v0" class="fitem" style="background:#008000">全て</div><!--
	--><div id="v1" class="fitem">女子</div><!--
	--><div id="v2" class="fitem">男子</div><!--
	--><div id="v3" class="fitem">和風</div><!--
	--><div id="v4" class="fitem">自然</div><!--
	--><div id="v5" class="fitem">季節</div><!--
	--><div id="v6" class="fitem">厨二</div><!--
	--><div id="v7" class="fitem">限定</div><!--
--></div>
	<div class="fbox1a"><?=$list_n["l"]?></div>
	<div class="fbox1a_page"><?=$list_n["p"]?><?=$list_n["c"]?><?=$list_n["n"]?></div>
</div>
<div class="folder_all2">
	<div class="fbox2">
		<div class="img_view"><img id="view" class="view" src="./img/noimage0.png"></div>
		<label for="upd" class="upload_btn"><span class="icon_img icon_upd"></span>画像選択</label>　<span class="img_rote icon_img icon_6"></span><br>
	</div>
</div>

<div class="folder_all3">
	<div class="fbox3">
		<?if($exp>=100){?>
			<div class="item1"><span class="icon_img icon_9" style="margin:0 1.5vw"></span>QRコード</div><div class="item3">QRコードを一つ設定できます。</div>
			<div class="item2">
				<div id="qr_select" class="item2_box"><span class="qr_option_icon"></span><span class="qr_option_txt">onlyme</span></div>
				<div class="item2_box_d">▼</div>
				<div id="qr_option" class="qr_option">	
					<span id="qr1" class="qr_option_a"><span class="qr_option_icon"></span><span class="qr_option_txt">onlyme</span></span>
					<span id="qr3" class="qr_option_a word2_c3"><span class="qr_option_icon"></span><span class="qr_option_txt">twitter</span></span>
					<span id="qr4" class="qr_option_a word2_c4"><span class="qr_option_icon"></span><span class="qr_option_txt">Instagram</span></span>
					<span id="qr5" class="qr_option_a word2_c5"><span class="qr_option_icon"></span><span class="qr_option_txt">Cosplayer Archive</span></span>
					<span id="qr2" class="qr_option_a"><span class="qr_option_icon"></span><span class="qr_option_txt">未使用</span></span>
				</div>
			</div>
		<?}?>
		<input type="hidden" id="qr" value="<?=$prof["qr"]?>" name="qr">
	 
		<div class="item1"><span class="icon_img icon_9" style="margin:0 1.5vw"></span>ハンドル</div><div class="item3">10字まで</div>
		<div class="item2"><input id="ck_name" type="text" name="name" value="<?=$prof["name"]?>" class="item2_box" maxlength="10"></div>

		<div class="item1"><span class="icon_img icon_9" style="margin:0 1.5vw"></span>作品名</div><div class="item3">12字まで</div>
		<div class="item2"><input id="ck_orgin" type="text" name="orgin" value="<?=$prof["orgin"]?>" class="item2_box" maxlength="12"></div>

		<div class="item1"><span class="icon_img icon_9" style="margin:0 1.5vw"></span>Twitter</div><div class="item3">ツイッターID</div>
		<div class="item2"><input id="ck_twitter" type="text" name="twitter" value="<?=$prof["twitter"]?>" class="item2_box"></div>

		<div class="item1"><span class="icon_img icon_9" style="margin:0 1.5vw"></span>Instagram</div><div class="item3">インスタグラムID</div>
		<div class="item2"><input id="ck_insta" type="text" name="insta" value="<?=$prof["insta"]?>" class="item2_box"></div>

		<div class="item1"><span class="icon_img icon_9" style="margin:0 1.5vw"></span>Cosp</div><div class="item3">Cosplayer ArchiveID</div>
		<div class="item2"><input id="ck_cosp" type="number" name="cosp" value="<?=$prof["cosp"]?>" class="item2_box"></div>
	</div>
</div>
<div class="fsample_md">
<img class="fsample_md_img">
<div class="fsample_md_com">
TP0001 男子　女子　季節<br>
用紙：縦<br>
名前：横書<br>
作品：横書<br>
<br>
利用数<br>
</div>
<div class="fsample_md_btn">
<div class="fsample_ok btn c2">使用</div>
<div class="fsample_ng btn c1">取消</div>
<?if($user["id"]<10002014){?>
<div class="fsample_if btn icon_img"></div>
</div>
<?}?>
</div>
</form>
</div>
<input id="upd" type="file" accept="image/*" style="display:none;">
<canvas id="cvs1" style=" background:#fff0e0; display:none;"></canvas>
<?include_once("./x_foot.php")?>
</body>
</html>