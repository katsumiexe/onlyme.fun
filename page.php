<?php
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/no_session.php");
$nowpage=1;
$ex=8;
$d=0;

	$es=$_REQUEST["es"];

	if($es){
		$sql ="SELECT * FROM `me_encode`";
		if($re = mysqli_query($mysqli,$sql)){
			while($de = mysqli_fetch_assoc($re)){
				$me_enc[$de["key"]]=$de["value"];
			}
		}

		$t=strlen($es)/2;
		for($n=0;$n<$t;$n++){
			$t2=substr($es,$n*2,2);
			$es2.=$me_enc[$t2];			
		}
		$es2+=0;
	}

	$e_pritty	=0;
	$e_smart	=0;
	$e_funny	=0;
	$e_sexy		=0;

	$sql ="SELECT * FROM `me_making`";
	$sql.=" LEFT JOIN me_iine ON making_id=i_card_id";
	$sql.=" WHERE me_making.making_id='{$es2}'";
	
	$re = mysqli_query($mysqli,$sql);
	$de = mysqli_fetch_assoc($re);

	$e_pritty	+=$de["pritty"]+0;
	$e_smart	+=$de["smart"]+0;
	$e_funny	+=$de["funny"]+0;
	$e_sexy		+=$de["sexy"]+0;

	if($user["id"]=== $de["i_user_id"]){
		$iine_kind	="pritty";
		$iine_pts	=$de["pritty"];

	}elseif($de["smart"]>0){
		$iine_kind	="smart";
		$iine_pts	=$de["smart"];

	}elseif($de["funny"]>0){
		$iine_kind	="funny";
		$iine_pts	=$de["funny"];

	}elseif($de["sexy"]>0){
		$iine_kind	="sexy";
		$iine_pts	=$de["sexy"];
	}

	for($n=0;$n<4;$n++){
		$tmp_key=substr($de["user_id"],$n*2,2);
		$tmp_enc[$n]=$enc[$tmp_key];
	}

	//■------------------------

	$list_enc=$tmp_enc[0].$tmp_enc[3].$tmp_enc[1].$tmp_enc[2].$tmp_enc[3].$tmp_enc[2];
	$sub_img	="./myalbum/{$tmp_enc[3]}/{$list_enc}/{$tmp_enc[1]}{$tmp_enc[3]}/{$de["img2"]}";
	$mdate=substr($de["makedate"],5,2)."/".substr($de["makedate"],8,2)."　".substr($de["makedate"],11,2).":".substr($de["makedate"],14,2);

	$host_id=$de["user_id"];


$sql ="SELECT * FROM `reg`";
$sql .=" LEFT JOIN me_prof ON reg.id=me_prof.prof_id";
$sql .=" WHERE reg_rank>'10'";
$sql .=" AND id='{$host_id}'";

$result = mysqli_query($mysqli,$sql);
$user_ck = mysqli_fetch_assoc($result);

if($user_ck){
	for($n=0;$n<4;$n++){
		$f_tmp_key=substr($host_id,$n*2,2);
		$f_tmp_enc[$n]=$enc[$f_tmp_key];
	}

	$f_list_enc=$f_tmp_enc[0].$f_tmp_enc[3].$f_tmp_enc[1].$f_tmp_enc[2].$f_tmp_enc[3].$f_tmp_enc[2];
	$f_tmp=substr("0".$f_tmp_key+$user_ck["reg_pic"],-2,2);

	if($user_ck["reg_pic"]>0){
		$host_face	= "./myalbum/{$f_tmp_enc[3]}/{$f_list_enc}/{$f_tmp_enc[3]}{$f_tmp_enc[2]}/{$enc[$f_tmp]}.jpg";
	}else{
		$host_face	= "./img/noimage{$user_ck["reg_sex"]}.jpg";
	}



	$sql2 ="SELECT count(log_id) as cnt, log_no, max(exp) as m_exp, day, action FROM log"; 
	$sql2.=" WHERE user_id='{$host_id}'";
	$sql2.=" GROUP BY day,log_no";

	$result2 = mysqli_query($mysqli,$sql2);
	while($row2 = mysqli_fetch_assoc($result2)){
		if($row2["log_no"] == 300){

			if($row2["cnt"]>10){
				$row2["cnt"]=10;
			}
			$host_exp+=	$row2["cnt"];

		}elseif($row2["log_no"] == 301){

			if($row2["cnt"]>5){
				$row2["cnt"]=5;
			}
			$host_exp+=	$row2["cnt"]*2;

		}elseif($row2["log_no"] == 302){
			$making+=$row2["cnt"];
			if($row2["cnt"]>2){
				$row2["cnt"]=2;
			}
			$host_exp+=	$row2["cnt"]*5;

		}else{
			$host_exp+=	$row2["m_exp"];
		}
	}

	$prof_lv=ceil($host_exp/100);

	if($user_ck["open_twitter"] == 1){
		$dat_p["twitter"]	=str_replace("@","","https://mobile.twitter.com/".$user_ck["twitter"]);
	}

	if($user_ck["open_cosp"] == 1){
		$dat_p["cosp"]	="https://sp.cosp.jp/prof.aspx?id=".$user_ck["cosp"];
	}

	if($user_ck["open_insta"] == 1){
		$dat_p["insta"]	=str_replace("@","","https://instagram.com/".$user_ck["insta"]);
	}

	for($n=0;$n<4;$n++){
		$tmp_key=substr($host_id,$n*2,2);
		$tmp_enc[$n]=$enc[$tmp_key];
	}
	$list_enc=$tmp_enc[0].$tmp_enc[3].$tmp_enc[1].$tmp_enc[2].$tmp_enc[3].$tmp_enc[2];
	$card_url	="./myalbum/{$tmp_enc[3]}/{$list_enc}/{$tmp_enc[1]}{$tmp_enc[3]}/";

	$sql3="SELECT * FROM me_iine";
	$sql3.=" WHERE i_host_id='{$host_id}'";
	$sql3.=" AND (pritty>0 || smart>0 || funny>0 || sexy>0)";

	$result3 = mysqli_query($mysqli,$sql3);
	while($iine0 = mysqli_fetch_assoc($result3)){

		$iine[$iine0["i_card_id"]]	+=$iine0["pritty"];
		$iine[$iine0["i_card_id"]]	+=$iine0["smart"];
		$iine[$iine0["i_card_id"]]	+=$iine0["funny"];
		$iine[$iine0["i_card_id"]]	+=$iine0["sexy"];

		$pritty_all +=$iine0["pritty"];
		$smart_all	+=$iine0["smart"];
		$funny_all	+=$iine0["funny"];
		$sexy_all	+=$iine0["sexy"];
	}

	$sql ="SELECT * FROM `me_making`";
	$sql.=" WHERE `del`='0'";
	$sql.=" AND `user_id`='{$host_id}'";
	$sql.=" ORDER BY making_id DESC";
	$sql.=" LIMIT 20";

	$result = mysqli_query($mysqli,$sql);
	while($dat2 = mysqli_fetch_assoc($result)){
		$dat[$d]=$dat2;

		$dat[$d]["img_url"]	=$card_url.$dat2["img2"];
		$dat[$d]["mdate"]	=substr($dat2["makedate"],5,2)."/".substr($dat2["makedate"],8,2)."　".substr($dat2["makedate"],11,2).":".substr($dat2["makedate"],14,2);
		$dat[$d]["tl"]		=get_after($dat2["makedate"]);

		for($n=0;$n<4;$n++){
			$tmp_key=substr($dat2["user_id"],$n*2,2);
			$tmp_enc[$n]=$enc[$tmp_key];
		}

		$sql2="SELECT count(card_id) as cnt,card_id FROM me_cheer";
		$sql2.=" WHERE del=0";
		$sql2.=" AND host_id='{$host_id}'";
		$sql2.=" AND com IS NOT NULL";
		$sql2.=" GROUP BY card_id";
		$s=0;

		$result2 = mysqli_query($mysqli,$sql2);
		while($cheer0 = mysqli_fetch_assoc($result2)){
			$cheer[$cheer0["card_id"]]=$cheer0["cnt"];
		}
		$d++;
	}

	$sql4 ="SELECT * FROM me_fav";
	$sql4.=" WHERE fav_host_id='{$host_id}'";
	$sql4.=" AND fav_set>0";

	$result4 = mysqli_query($mysqli,$sql4);
	while($fav0 = mysqli_fetch_assoc($result4)){
		if($fav0["fav_set"]>0){
			$fav_all++;
			if($fav0["fav_user_id"]==$user["id"]){
				$fav_ck=1;
			}
		}
	}

}else{
	$no_user=1;
}
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

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="<?=$twitter?>">
<meta property="og:url" content="https://onlyme.fun/profile.php?es=<?=$e_host?>">
<meta property="og:title" content="<?=$name?>さんの名刺　-OnlyMe-">
<meta property="og:description" content="PC不要、住所不要、スマホで作成、コンビニで印刷。簡単手軽な写真名刺制作サイト">
<meta property="og:image" content="<?=$img?>">

<link rel="stylesheet" href="./css/set_icon.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/first.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/index.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/onlyme.css?_<?=date("YmdHi")?>">

<style>
.prof_main{
	position:absolute;
	left:0.5vw;
	top:1.5vw;
	width:99vw;
	height:28vw;
	background:#ffe0f0;
	background:linear-gradient(#f8e8ff,#f0e0ff);
	z-index:1;
}

.prof_table{
	position:absolute;
	border-collapse: collapse;
	left:1vw;
	top:2vw;
	width:46vw;
	border:0.2vw solid #f17766;
}

.prof_photo{
	position:relative;
	border:0.2vw solid #f17766;
	padding:0;
	background:#ffffff;
}

.prof_img{
	position:absolute;
	top:0;
	left:0;
	right:0;
	bottom:0;
	margin:auto;
	width:22vw;
	height:22vw;
}

.prof_item{
	position:relative;
	border:0.2vw solid #f17766;
	width:22vw;
	height:5.7vw;
	line-height:5.2vw;
	padding:0;
	background:#ffffff;
	text-align:left;
	font-size:3vw;
	color:#ff90c0;
	font-weight:600;
}

.item_ttl{
	display:inline-block;
	position:absolute;
	top:0.5vw;
	left:0.5vw;
	height:4.2vw;
	width:11vw;
	text-align:left;
}

.item_no{
	display:inline-block;
	position:absolute;
	top:0.5vw;
	right:0.5vw;
	height:4.2vw;
	width:9vw;
	text-align:right;
}

.prof_name{
	position:absolute;
	top:2vw;
	right:1.5vw;
	width:48vw;
	height:6vw;
	line-height:6.5vw;
	text-align:left;
	font-size:3.6vw;
	color:#ffa0c0;
	font-weight:600;
	background:#ffffff;
	border-bottom:0.5vw solid #f17766;
	padding-left:1vw;
}

.prof_iine{
	position:absolute;
	top:10vw;
	border-bottom:0.5vw solid #f17766;
	width:11.5vw;
	height:5vw;
	line-height:4.5vw;
	padding:0;
	background:#ffffff;
	box-sizing: border-box;
}

.iine_icon{
	position:absolute;
	top:0;
	left:0;
	width:4.5vw;
	height:5vw;
	line-height:5vw;
	font-size:4vw;
	background:#f17766;
	color:#ffffff;
	text-align:center;
}

.iine_no{
	position:absolute;
	top:0;
	right:0.5vw;
	width:6.5vw;
	height:5vw;
	line-height:5vw;
	color:#f17766;
	font-size:3vw;
	text-align:right;
}

.p4{right:1.5vw;}
.p3{right:14vw;}
.p2{right:26.5vw;}
.p1{right:38.5vw;}


.prof_fav{
	position:absolute;
	top:17vw;
	width:19.5vw;
	height:7.5vw;
	line-height:7.5vw;
	border:0.5vw solid #ffa0e0;
	background:#ffffff;
	color:#ffa0e0;
	border-radius:1vw;
	text-align:left;
	font-size:3.2vw;
	cursor:pointer;
	padding-left:1vw;
	font-weight:600;
}

.prof_fav_on{
	color:#ffffff;
	background:linear-gradient(#ffb0f0,#ffa0e0);
	border:0.5vw solid #ffa0e0;
	text-shadow:0.3vw 0.3vw 0.3vw rgba(200,0,0,0.5);
}

.prof_out{
	position:absolute;
	width:7vw;
	height:7vw;
	line-height:7vw;
	top:17vw;
	font-family:at_icon;
	text-align:center;
	font-size:5vw;
	color:#ffffff;
}

.s3{right:1.5vw;}
.s2{right:10.5vw;}
.s1{right:19.5vw;}
.s0{right:29vw;}

.p_twitter{
	border:0.5vw solid #55ACEE;
	background:linear-gradient(#70b0ff,#55ACEE);
}
.p_insta{
	border:0.5vw solid #ff7f50;
	background:linear-gradient(#ff7f50,#ff9060);
}
.p_cosp{
	border:0.5vw solid #ff0000;
	background:linear-gradient(#ff9090,#ff0000);
}

.p_url{
	border:0.5vw solid #008000;
	background:linear-gradient(#40c050,#00a000);
}
.p_fb{
	border:0.5vw solid #3D5A99;
	background:linear-gradient(#5972A7,#3D5A99);
}
.p_off{
	border:0.5vw solid #cccccc;
	background:linear-gradient(#eeeeee,#cccccc);
}

.fence{
	position:absolute;
	bottom:-2vw;
	display:inline-block;
	width:5.5vw;
	height:2.5vw;
	background:#f0e0ff;
	border-radius:0 0 2.5vw 2.5vw;
	box-shadow:0.5vw 0.5vw 0.5vw rgba(0,0,0,0.4);
}

.f1{left:0.5vw;}
.f2{left:6vw;}
.f3{left:11.5vw;}
.f4{left:17vw;}
.f5{left:22.5vw;}

.f6{left:28vw;}
.f7{left:33.5vw;}
.f8{left:39vw;}
.f9{left:44.5vw;}
.f10{left:50vw;}

.f11{left:55.5vw;}
.f12{left:61vw;}
.f13{left:66.5vw;}
.f14{left:72vw;}

.f15{left:77.5vw;}
.f16{left:83vw;}
.f17{left:88.5vw;}
.f18{left:93vw;}

.album_box{
	text-align:left;
	display:flex;
	flex-wrap:wrap;
	width:99vw;
	background:#e0e0e0;
	margin:0 auto;
}

.album_frame{
	flex-basis:44vw;
	border:1vw solid #ffffff;
	padding:0;
	margin:1.5vw;
	color:#ffffff;
}

.album_img{
	width:44vw;
	height:72.8vw;
}

.album_prof{
	display:inline-flex;
	width:44vw;
	height:5vw;
	background:linear-gradient(#ff9988,#f17766);
}

.album_time{
	display:inline-block;
	flex:1;
	height:5vw;
	line-height:5vw;
	font-size:3vw;
	font-weight:600;
	text-shadow:0.2vw 0.2vw 0 rgba(0,0,0,0.4);
	padding-left:1vw;
	color:#f0f0f0;
}

.album_iine{
	display:inline-block;
	flex-basis:12vw;
	height:5vw;
	line-height:5vw;
	font-size:3vw;
	font-weight:600;
}

.album_iine_i{
	display:inline-block;
	font-family:at_icon;
	width:5vw;
	height:5vw;
	text-align:center;
	line-height:5vw;
	font-size:3vw;
	text-shadow:0.2vw 0.2vw #d00000;
}

.album_comm{
	display:inline-block;
	flex-basis:12vw;
	height:5vw;
	line-height:5vw;
	font-size:3vw;
	font-weight:600;
}

.album_comm_i{
	display:inline-block;
	font-family:at_icon;
	width:4vw;
	height:5vw;
	text-align:center;
	line-height:5vw;
	font-size:3vw;
	text-shadow:0.2vw 0.2vw #d00000;
}
.pbox{
	padding-top:30vw;

}

</style>
<script src="./js/jquery-3.4.1.min.js"></script>
<script src="./js/index.js"></script>

<script>
var VwBase =$(window).width()/100;
var VhBase =$(window).height()/100;
var ChBase =(VhBase*100)-(VwBase*101);
var User_id =<?=$user["id"]?>;
var iine_Pt =<?=$iine_pt+0?>;
var TopNow	=0;
var NextCk	=0;
var Img_id	=0;

$(function(){ 
	<?if($es2){?>
	Img_id	= '<?=$es2?>';
	MySel	= '<?=$iine_kind?>';
	Minus	= '<?=$iine_pts?>';

	Own		= '<?=$host_id?>';
	Pict	= '<?=$host_id?>';
	Mdate	= '<?=$host_id?>';

	Pritty	= '<?=$pritty+0?>';
	Smart	= '<?=$smart+0?>';
	Funny	= '<?=$funny+0?>';
	Sexy	= '<?=$sexy+0?>';

	$('#e_pritty').text(Pritty);
	$('#e_smart').text(Smart);
	$('#e_funny').text(Funny);
	$('#e_sexy').text(Sexy);

	AllIine	= '<?=$pritty+$smart+$funny+$sexy+0?>';
	Img_Url	='<?=$sub_img?>';
	Mdate	='<?=$mdate?>';
	Img_Name=`<?=$row2["reg_name"]?>`;

	$('#tmpl').attr({'src':Img_Url});
	$('.p_name').text(Img_Name);
	$('.p_date').text(Mdate);
	$('#p_pict').attr('src',Pict);

	$('.p_page').animate({'left': '0.5vw'},150);

	if(Own == User_id){
		$('.p_page_msg_a').addClass('iine_my_a');
		$('.p_page_msg_c').addClass('iine_my_c2');
		$('.set_cheer').addClass('cheer_no');

	}else if(MySel){	
		$('#'+MySel).addClass('ii_'+MySel);
		$('#e_'+MySel).addClass('iine_my_c1');
	}

	$('.p_cheer_cld').hide();
	$('.i'+Img_id).show();
	$('.prof_table').hide();
	$('.main').hide();

	<?}?>

	$('#no_2,.pop00').on('click',function () {
		$('.pop00').fadeOut(200);
	});

	$('.p_twitter').on('click',function (){
		$('.jump_box2_1').css({'background':'linear-gradient(#70b0ff,#55ACEE)'}).text("");
		$('.pop00').show();
		$('#jump').text('<?=$dat_p["twitter"]?>');
	});

	$('.p_insta').on('click',function (){
		$('.jump_box2_1').css({'background':'linear-gradient(#70b0ff,#55ACEE)'}).text("");
		$('.pop00').show();
		$('#jump').text('<?=$dat_p["insta"]?>');
	});

	$('.p_cosp').on('click',function (){
		$('.jump_box2_1').css({'background':'linear-gradient(#ff9090,#ff0000)'}).text("");
		$('.pop00').show();
		$('#jump').text('<?=$dat_p["cosp"]?>');
	});

	$('#yes_link').on('click',function(){
		Jump=$('#jump').text();
		$('#form_out').attr('action',Jump);
		$('#form_out').submit();
	});

	$('.prof_fav').on('click',function () {
		if($(this).hasClass('prof_fav_on')){
			$(this).removeClass('prof_fav_on');
			$.post("post_set_fav.php",
			{
			'user_id':'<?=$user["id"]?>',
			'host_id':'<?=$host_id?>',
			'fav_set':0
			},
			function(){
				var fav_Tmp=$('#p_fav').text();	
				fav_Tmp=parseFloat(fav_Tmp)-1;
				$('#p_fav').text(fav_Tmp);
			});
		
		}else{
			$(this).addClass('prof_fav_on');
			$.post("post_set_fav.php",
			{
			'user_id':'<?=$user["id"]?>',
			'host_id':'<?=$host_id?>',
			'fav_set':1
			},
			function(){
				var fav_Tmp=$('#p_fav').text();	
				fav_Tmp=parseFloat(fav_Tmp)+1;
				$('#p_fav').text(fav_Tmp);
			});
		}
	});
});
</script>
</head>
<body class="body">
<?if(!$_SESSION["id"]){?>
<?
$t_re=$_SERVER["HTTP_REFERER"];
$t_ua=$_SERVER['HTTP_USER_AGENT'];
$t_ip=$_SERVER["REMOTE_ADDR"];
if(!$t_re) $t_re="null";
if(!$t_ua) $t_ua="null";
$log_date = date("Y-m-d H:i:s");
$sql="INSERT INTO me_alllog(`log_date`,`log_ref`,`log_ua`,`log_ip`) VALUES('{$log_date}','{$t_re}','{$t_ua}','{$t_ip}')";
mysqli_query($mysqli,$sql);
?>
<?include_once("./onlyme.php")?>
<?}else{?>
<?include_once("./x_head.php")?>
<div class="main">
	<div class="prof_main">
		<table class="prof_table">
			<tr>
				<td rowspan="4" class="prof_photo"><img src="<?=$host_face?>" class="prof_img"></td>
				<td class="prof_item"><span class="item_ttl">レベル</span><span id="p_lv" class="item_no"><?=$prof_lv?></span></td>
			</tr>
			<tr>
				<td class="prof_item"><span class="item_ttl">ファン</span><span id="p_fav" class="item_no"><?=$fav_all+0?></span></td>
			</tr>
			<tr>
				<td class="prof_item"><span class="item_ttl">友達数</span><span class="item_no">0</span></td>
			</tr>
			<tr>
				<td class="prof_item"><span class="item_ttl">応援数</span><span class="item_no"><?=$cheer_cnt_host+0?></span></td>
			</tr>
		</table>
		<div class="prof_name"><?=$user_ck["reg_name"]?></div>
		<div class="prof_iine p1"><span class="iine_icon icon_img"></span><span class="iine_no"><?=$pritty_all+0?></span></div>
		<div class="prof_iine p2"><span class="iine_icon icon_img"></span><span class="iine_no"><?=$smart_all+0?></span></div>
		<div class="prof_iine p3"><span class="iine_icon icon_img"></span><span class="iine_no"><?=$funny_all+0?></span></div>
		<div class="prof_iine p4"><span class="iine_icon icon_img"></span><span class="iine_no"><?=$sexy_all+0?></span></div>

		<?if($host_id !=$user["id"]){?><div class="prof_fav s0 <?if($fav_ck==1){?>prof_fav_on<?}?>">★ファン登録</div><? } ?>
		<div class="prof_out s1 <?if($dat_p["twitter"]){?>p_twitter<?}else{?>p_off<?}?>"></div>
		<div class="prof_out s2 <?if($dat_p["insta"]){?>p_insta<?}else{?>p_off<?}?>"></div>
		<div class="prof_out s3 <?if($dat_p["cosp"]){?>p_cosp<?}else{?>p_off<?}?>"></div>

		<div class="fence f1"></div>
		<div class="fence f2"></div>
		<div class="fence f3"></div>
		<div class="fence f4"></div>
		<div class="fence f5"></div>

		<div class="fence f6"></div>
		<div class="fence f7"></div>
		<div class="fence f8"></div>
		<div class="fence f9"></div>
		<div class="fence f10"></div>

		<div class="fence f11"></div>
		<div class="fence f12"></div>
		<div class="fence f13"></div>
		<div class="fence f14"></div>
		<div class="fence f15"></div>

		<div class="fence f16"></div>
		<div class="fence f17"></div>
		<div class="fence f18"></div>
	</div>
	<div class="index_box pbox">
		<?for($n=0;$n<20;$n++){?>

			<div id="f<?=$dat[$n]["making_id"]?>" class="index_frame">
				<input type="hidden" name="own" value="<?=$dat[$n]["user_id"]+0?>">
				<input type="hidden" name="mdate" value="<?=$dat[$n]["mdate"]?>">

				<input id="mm<?=$dat[$n]["making_id"]?>" type="hidden" name="mysel" value="<?=$mysel[$dat[$n]["making_id"]]?>">
				<input id="mi<?=$dat[$n]["making_id"]?>" type="hidden" name="minus" value="<?=$minus[$dat[$n]["making_id"]]+0?>">
				<input id="pp<?=$dat[$n]["making_id"]?>" type="hidden" name="pritty" value="<?=$pritty[$dat[$n]["making_id"]]+0?>">
				<input id="ss<?=$dat[$n]["making_id"]?>" type="hidden" name="smart" value="<?=$smart[$dat[$n]["making_id"]]+0?>">
				<input id="ff<?=$dat[$n]["making_id"]?>" type="hidden" name="funny" value="<?=$funny[$dat[$n]["making_id"]]+0?>">
				<input id="xx<?=$dat[$n]["making_id"]?>" type="hidden" name="sexy" value="<?=$sexy[$dat[$n]["making_id"]]+0?>">
				<input id="al<?=$dat[$n]["making_id"]?>" type="hidden" name="all" value="<?=$pritty[$dat[$n]["making_id"]]+$smart[$dat[$n]["making_id"]]+$funny[$dat[$n]["making_id"]]+$sexy[$dat[$n]["making_id"]]+0?>">

				<div class="album_prof">
				<span class="album_time"><?=$dat[$n]["tl"]?></span>
				<span class="album_iine"><span class="album_iine_i"></span><?=$iine[$dat[$n]["making_id"]]+0?></span>
				<span class="album_comm"><span class="album_comm_i"></span><?=$cheer[$dat[$n]["making_id"]]+0?></span>
				</div>
				<img src="<?=$dat[$n]["img_url"]?>" class="index_img" alt="<?=$dat[$n]["reg_name"]?>">
			</div>
		<? } ?>
		<div id="next_20" class="next">続き</div>
	</div>
</div>

<div class="p_page">
	<img id="tmpl" class="p_page_img">
	<div class="tbl_p_page_msg">
		<div class="tbl_p_pic"><img id="p_pict"></div>
		<div class="tbl_p1"><span class="p_date"></span></div>
		<div class="tbl_p2"><span class="icon_img"></span></div>
		<div class="tbl_p3"><span id="all_cheer"></span></div>
		<div class="tbl_p_name"><span class="p_name"></span></div>
	</div>

	<div id="pritty" class="p_page_msg_a<?if($host_id == $user["id"]){?>_my<?}?> ii_1">
		<span class="icon_img p_page_icon"></span>
		<span class="p_page_msg_b">カワイイ</span>
		<span id="e_pritty" class="p_page_msg_c<?if($host_id == $user["id"]){?> iine_my_c2<?}?>"></span>
	</div>

	<div id="smart" class="p_page_msg_a<?if($host_id == $user["id"]){?>_my<?}?> ii_2">
		<span class="icon_img p_page_icon"></span>
		<span class="p_page_msg_b">イケメン</span>
		<span id="e_smart" class="p_page_msg_c<?if($host_id == $user["id"]){?> iine_my_c2<?}?>"></span>
	</div>

	<div id="funny" class="p_page_msg_a<?if($host_id == $user["id"]){?>_my<?}?> ii_3">
		<span class="icon_img p_page_icon"></span>
		<span class="p_page_msg_b">オモシロ</span>
		<span id="e_funny" class="p_page_msg_c<?if($host_id == $user["id"]){?> iine_my_c2<?}?>"></span>
	</div>

	<div id="sexy" class="p_page_msg_a<?if($host_id == $user["id"]){?>_my<?}?> ii_4">
		<span class="icon_img p_page_icon"></span>
		<span class="p_page_msg_b">セクシー</span>
		<span id="e_sexy" class="p_page_msg_c<?if($host_id == $user["id"]){?> iine_my_c2<?}?>"></span>
	</div>

	<div id="p_page_out" class="p_page_size"><span class="p_icon_icon icon_img"></span><span class="p_icon_comment">戻る</span></div>
	<div id="p_page_prof" class="p_page_size"><span class="p_icon_icon icon_img"></span><span class="p_icon_comment">プロフ</span></div>
	<div id="p_page_comment" class="p_page_size"><span class="p_icon_icon icon_img"></span><span class="p_icon_comment">応援</span></div>
	<div id="p_page_alert" class="p_page_size alt_yet"><span class="p_icon icon_img"></span><span class="p_icon_comment">通報</span></div>

	<div class="p_cheer">
		<div class="cheer_list"></div>
		<div class="set_cheer"><span class="icon_img"></span>応援！</div>
	</div>

	<form id="jump_p" action="./profile.php" method="post">
	<input id="jump_id" type="hidden" name="host" value="">	
	</form>
	<div class="pop01">
		<div class="pop01_a">
			<div style="padding:0.5vw; text-align:left;font-size:3.2vw;">
			</div>
			<div style="text-align:center;width:100%;">
				<textarea class="pop01_c" name=""></textarea>
				<div id="yes_1" class="btn c2">通報</div>　
				<div id="no_1" class="btn c1">取消</div>
			</div>
			<div style="padding:0.5vw; text-align:left;font-size:3.2vw;">
				通報された投稿はスタッフが確認を行い、不適切と判断されましたら削除されます。<br>
				通報された投稿が必ずしも削除されるわけではありません。<br>
				削除ガイドライン<br>
				・公序良俗に反する画像<br>
				・著作権を侵害していると思われる画像<br>
				・個人情報に抵触していると思われる画像<br>
			</div>
		</div>
		<div class="pop01_e">
			通報しました。
		</div>
	</div>

	<div class="pop02">
		自分の投稿には評価を付けられません。
	</div>
	<div class="pop03">
		「評価」をすると応援コメントを送れます。
	</div>
	<div class="pop04">
	「こっそり応援」は他の人には見れません。
	</div>
	<div class="pop05">
		自分の投稿は通報できません。
	</div>
	<div class="pop06">
		自分の投稿には応援できません。
	</div>

	<div class="pop07">
		<div class="pop07_a">
			<div style="text-align:center;width:100%;">
				<textarea id="p_cheer_box" class="p_cheer_box" name="p_cheer_box"></textarea>
				<div class="cheer_sel">　
					<div id="p_cheer_sub" class="btn c2">応援</div>　
					<div id="no_1" class="btn c1">取消</div>　
					<div id="p_cheer_del" class="btn c3">消去</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="pop00">
	<div class="pop00_a">
	<table class="jump_box2">
		<tr>
			<td class="jump_box2_1"></td>
			<td class="jump_box1"><span id="jump"></span></td>
		</tr>
		<tr>
			<td colspan="2" class="jump_box2_2">外部のサイトへ移動します。<br>よろしいですか。<br></td>
		</tr>
	</table>
	<div id="yes_link" class="btn c2">移動</div>　		<div id="no_2" class="btn c1">取消</div>
	</div>
</div>
<form id="form_out" action="" method="post" target="_blank"></form>
<?include_once("./x_foot.php")?>
<? } ?>
</body>
</html>
