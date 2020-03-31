<?php
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/no_session.php");

$ex=8;
$d=0;

$date_30=date("Y-m-d H:i:s",time()-2592000);

$es		=$_REQUEST["es"];

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
        $jump_id.=$me_enc[$t2];			
    }
    $jump_id+=0;

	$sql ="SELECT sum(me_iine.pritty) as e_pritty, sum(me_iine.smart) as e_smart, sum(me_iine.funny) as e_funny, sum(me_iine.sexy) as e_sexy, ";
	$sql.="makedate, user_id, img2, reg_name, reg_pic, reg_sex,";
	$sql.="me_prof.twitter, me_prof.insta, me_prof.cosp, me_prof.open_twitter, me_prof.open_insta, me_prof.open_cosp";
	$sql.=" FROM `me_making`";

	$sql.=" LEFT JOIN `me_iine` ON me_making.user_id=i_host_id";
	$sql.=" LEFT JOIN `reg` ON me_making.user_id=reg.id";
	$sql.=" LEFT JOIN `me_prof` ON me_making.user_id=me_prof.prof_id";

	$sql.=" WHERE me_making.making_id='{$jump_id}'";
	$sql.=" AND me_making.del='0'";
	$sql.=" AND reg.reg_rank>10";
	$sql.=" GROUP BY me_making.making_id";
	$re = mysqli_query($mysqli,$sql);
	$de = mysqli_fetch_assoc($re);

	if($de){
		$e_pritty	+=$de["e_pritty"]+0;
		$e_smart	+=$de["e_smart"]+0;
		$e_funny	+=$de["e_funny"]+0;
		$e_sexy		+=$de["e_sexy"]+0;

		for($n=0;$n<4;$n++){
			$tmp_key=substr($de["user_id"],$n*2,2);
			$tmp_enc[$n]=$enc[$tmp_key];
		}

		$list_enc=$tmp_enc[0].$tmp_enc[3].$tmp_enc[1].$tmp_enc[2].$tmp_enc[3].$tmp_enc[2];
		$sub_img	="myalbum/{$tmp_enc[3]}/{$list_enc}/{$tmp_enc[1]}{$tmp_enc[3]}/{$de["img2"]}";
		$mdate=substr($de["makedate"],0,4)."/".substr($de["makedate"],5,2)."/".substr($de["makedate"],8,2)."　".substr($de["makedate"],11,2).":".substr($de["makedate"],14,2);

		$f_tmp=substr("0".$tmp_key+$de["reg_pic"],-2,2);

		if($de["reg_pic"]>0){
			$f_tmp=substr("0".$tmp_key+$de["reg_pic"],-2,2);
			$host_face	= "./myalbum/{$tmp_enc[3]}/{$list_enc}/{$tmp_enc[3]}{$tmp_enc[2]}/{$enc[$f_tmp]}.jpg";

		}else{
			$host_face	= "./img/noimage{$de["reg_sex"]}.jpg";
		}

		$sql2 ="SELECT count(log_id) as cnt, log_no, max(exp) as m_exp, day, action FROM log"; 
		$sql2.=" WHERE user_id='{$de["user_id"]}'";
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

		if($de["open_twitter"] == 1){
			$dat_p["twitter"]	=str_replace("@","","https://mobile.twitter.com/".$de["twitter"]);
		}else{
			$card="@onlyme_staff";
		}

		if($de["open_cosp"] == 1){
			$dat_p["cosp"]	="https://sp.cosp.jp/prof.aspx?id=".$de["cosp"];
		}

		if($de["open_insta"] == 1){
			$dat_p["insta"]	=str_replace("@","","https://instagram.com/".$de["insta"]);
		}

		$sql ="SELECT";
		$sql .=" count(fav_id) as s_fav";
		$sql .=" FROM `me_fav`";
		$sql .=" WHERE fav_user_id='{$de["user_id"]}'";
		$sql .=" GROUP BY fav_user_id";

		$res = mysqli_query($mysqli,$sql);
		$res2 = mysqli_fetch_assoc($res);
		$fav =$res2["s_fav"];

		$sql ="SELECT";
		$sql .=" count(fav_id) as s_favd";
		$sql .=" FROM `me_fav`";
		$sql .=" WHERE fav_host_id='{$de["user_id"]}'";
		$sql .=" GROUP BY fav_host_id";

		$res = mysqli_query($mysqli,$sql);
		$res2 = mysqli_fetch_assoc($res);
		$favd	=$res2["s_favd"];

	}else{
		$no_user=1;
	}
}else{
	$no_user=1;
}

if(	$no_user==1){
$url = 'https://onlyme.fun';
header('Location: ' . $url, true, 301);
exit;
}

$t_re=$_SERVER["HTTP_REFERER"];
$t_ua=$_SERVER['HTTP_USER_AGENT'];
$t_ip=$_SERVER["REMOTE_ADDR"];
if(!$t_re) $t_re="null";
if(!$t_ua) $t_ua="null";
$log_date = date("Y-m-d H:i:s");
$sql="INSERT INTO me_alllog(`log_date`,`log_ref`,`log_ua`,`log_ip`,`log_at`) VALUES('{$log_date}','{$t_re}','{$t_ua}','{$t_ip}','pg')";
mysqli_query($mysqli,$sql);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>写真名刺制作サイト「OnlyMe」|<?=$de["reg_name"]?>さんの名刺</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
<meta name="description" content="PC不要、住所不要、スマホで作成、コンビニで印刷。手軽で簡単な写真名刺作成サイトです。">
<meta name="keywords" content="写真名刺,コスプレ,画像修正,onlyme,名刺作成,無料,簡単">
<link rel="canonical" href="https://onlyme.fun/">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="<?=$card?>">
<meta property="og:url" content="https://onlyme.fun/pg.php?es=<?=$es?>">
<meta property="og:title" content="<?=$de["reg_name"]?>さんの名刺　-OnlyMe-">
<meta property="og:description" content="PC不要、住所不要、スマホでデザイン、コンビニでプリント。無料で作れる写真名刺作成サイト">
<meta property="og:image" content="https://onlyme.fun/pg_img.php?es=<?=$es?>">

<link rel="stylesheet" href="./css/set_icon.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/first.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/index.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/profile.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/onlyme.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/pg.css?_<?=date("YmdHi")?>">

<script src="./js/jquery-3.4.1.min.js"></script>
<script src="./js/jquery-ui.min.js"></script>
<script src="./js/jquery.ui.touch-punch.min.js"></script>
<script src="./js/index.js"></script>

<script>
var VwBase =$(window).width()/100;
var VhBase =$(window).height()/100;

$(function(){ 
	$('#no_2,.pop00').on('click',function () {
		$('.pop00').fadeOut(200);
	});

	$('.p_twitter').on('click',function (){
		$('.jump_box2_1').css({'background':'linear-gradient(#70b0ff,#55ACEE)'}).text("");
		$('.pop00').show();
		$('#jump').text('<?=$dat_p["twitter"]?>');
	});

	$('.p_insta').on('click',function (){
		$('.jump_box2_1').css({'background':'linear-gradient(#ff7f50,#ff9060)'}).text("");
		$('.pop00').show();
		$('#jump').text('<?=$dat_p["insta"]?>');
	});

	$('.p_cosp').on('click',function (){
		$('.jump_box2_1').css({'background':'linear-gradient(#ff9090,#ff0000)'}).text("");
		$('.pop00').show();
		$('#jump').text('<?=$dat_p["cosp"]?>');
	});

	$('#yes_link').on('click',function(){
		Jump=$('#jump').text();
		$('#form_out').attr('action',Jump);
		$('#form_out').submit();
	});

	$('.new_btn').on('click',function(){
		$('#new_reg').submit();
	});
});
</script>

<!-- Twitter universal website tag code -->
<script>
!function(e,t,n,s,u,a){e.twq||(s=e.twq=function(){s.exe?s.exe.apply(s,arguments):s.queue.push(arguments);
},s.version='1.1',s.queue=[],u=t.createElement(n),u.async=!0,u.src='//static.ads-twitter.com/uwt.js',
a=t.getElementsByTagName(n)[0],a.parentNode.insertBefore(u,a))}(window,document,'script');
// Insert Twitter Pixel ID and Standard Event data below
twq('init','o32ga');
twq('track','PageView');
</script>
<!-- End Twitter universal website tag code -->
</head>
<body class="body">
<div class="pc_only">
	<img src="./pg_img.php?es=<?=$es?>" style="width:500px"><br>
	<div class="pc_qr">
		<img src="./qr_img_pg.php?es=<?=$es?>" style="width:128px">
	</div>

	<div class="pc_box" style="font-size:16px;">
		こちらはスマホ専用サイトです。<br>
		PC・タブレットではご利用いただけません。<br>
	</div>
</div>

<div class="main_irr sp_only">
<a href="./index.php" class="irr_top">写真名刺作成サイト★OnlyMe</a>
	<div class="prof_main2">
		<img src="<?=$host_face?>" class="prof_img">
		<div class="prof_name"><?=$de["reg_name"]?></div>
		<div class="prof_iine p1"><span class="iine_icon icon_img"></span><span class="iine_no"><?=$e_pritty+0?></span></div>
		<div class="prof_iine p2"><span class="iine_icon icon_img"></span><span class="iine_no"><?=$e_smart+0?></span></div>
		<div class="prof_iine p3"><span class="iine_icon icon_img"></span><span class="iine_no"><?=$e_funny+0?></span></div>
		<div class="prof_iine p4"><span class="iine_icon icon_img"></span><span class="iine_no"><?=$e_sexy+0?></span></div>

		<div class="prof_lv">LV:<span id="p_fav" class="item_no"><?=$prof_lv+0?></span></div>
		<div class="prof_follow">Follow:<span id="p_fav" class="item_no"><?=$fav+0?></span></div>
		<div class="prof_follower">Follower:<span id="p_fav" class="item_no"><?=$favd+0?></span></div>
		
		<div class="prof_out s1 <?if($dat_p["twitter"]){?>p_twitter<?}else{?>p_off<?}?>"></div>
		<div class="prof_out s2 <?if($dat_p["insta"]){?>p_insta<?}else{?>p_off<?}?>"></div>
		<div class="prof_out s3 <?if($dat_p["cosp"]){?>p_cosp<?}else{?>p_off<?}?>"></div>

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
		<div class="fence f19"></div>
		<div class="fence f20"></div>
	</div>

	<div class="index_frame_pg">
		<div class="pg_1"></div>
		<div class="pg_2"></div>
		<div class="pg_3"></div>
		<div class="pg_4"></div>
		<div class="pg_5"><img src="<?=$sub_img?>" class="pg_img" alt="<?=$de["reg_name"]?>さんの名刺"></div>
		<div class="pg_6"></div>
		<div class="pg_7"></div>
		<div class="pg_8"></div>
		<div class="pg_9"></div>
	</div>

	<div class="index_frame_bx">
		<div class="pg_login">
			<form id="user_login" action="./index.php" method="post">
				<input type="text" name="log_in" placeholder="ID or ADDRESS" class="pg_input"><br>
				<input type="password" name="log_pass" placeholder="PASSWORD" class="pg_input"><br>
				<button type="submit" class="pg_btn">LOGIN</button>
			</form>
		<span class="new_btn">新規登録</span>
		</div>
		<div class="pg_com">
		スマホでデザイン<br>コンビニでプリント<br>写真名刺を簡単作成<br>PC不要/住所不要<br>
		</div>
		<img src="img/logo_r.png" style="width:40vw">
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

<form id="new_reg" action="regist.php" method="post">
<input id="reg_code" type="hidden" name="reg_code" value="<?=$jump_id?>">
</form>


<?include_once("./x_foot.php")?>
</body>
</html>
