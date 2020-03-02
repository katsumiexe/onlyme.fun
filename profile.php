<?php
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/session.php");
$nowpage=1;
$ex=8;
$d=0;

$date_30=date("Y-m-d H:i:s",time()-2592000);

$e_host	=$_REQUEST["e_host"];
$es		=$_REQUEST["es"];

$host	=$_POST["host"];
$n_host	=$_POST["n_host"];

if($host){
	$host_id	=$host;

}elseif($n_host){
	$sql	="SELECT notice_id, n_user_id FROM `me_notice`";
	$sql	.=" WHERE notice_id={$n_host}";
	$dat_n		= mysqli_query($mysqli,$sql);
	$dat_n2		= mysqli_fetch_assoc($dat_n);
	$host_id	=$dat_n2["n_user_id"];

}elseif($e_host){
	if(substr($e_host,2,2) == substr($e_host,8,2)){
    	$host_id=$dec[substr($e_host,0,2)].$dec[substr($e_host,4,2)].$dec[substr($e_host,6,2)].$dec[substr($e_host,8,2)];
    }

}elseif($es){
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
}


if($jump_id){
	$sql ="SELECT * FROM `me_making`";
	$sql.=" LEFT JOIN `reg` ON me_making.user_id=reg.id";
	$sql.=" LEFT JOIN `me_iine` ON me_making.making_id=i_card_id";
	$sql.=" WHERE me_making.making_id='{$jump_id}'";
	$sql.=" AND me_making.del='0'";
	$sql.=" GROUP BY me_making.making_id";

	$re = mysqli_query($mysqli,$sql);
	$de = mysqli_fetch_assoc($re);

	$e_pritty	+=$de["pritty"]+0;
	$e_smart	+=$de["smart"]+0;
	$e_funny	+=$de["funny"]+0;
	$e_sexy		+=$de["sexy"]+0;

	if($user["id"]=== $de["i_user_id"]){
		if($de["smart"]>0){
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
	}

	for($n=0;$n<4;$n++){
		$tmp_key=substr($de["user_id"],$n*2,2);
		$tmp_enc[$n]=$enc[$tmp_key];
	}

	$list_enc=$tmp_enc[0].$tmp_enc[3].$tmp_enc[1].$tmp_enc[2].$tmp_enc[3].$tmp_enc[2];
	$sub_img	="./myalbum/{$tmp_enc[3]}/{$list_enc}/{$tmp_enc[1]}{$tmp_enc[3]}/{$de["img2"]}";
	$mdate=substr($de["makedate"],5,2)."/".substr($de["makedate"],8,2)."　".substr($de["makedate"],11,2).":".substr($de["makedate"],14,2);
	$host_id=$de["user_id"];
}

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

	$sql ="SELECT";
	$sql .=" sum(me_iine.pritty) as s_pritty,";
	$sql .=" sum(me_iine.smart) as s_smart,";
	$sql .=" sum(me_iine.funny) as s_funny,";
	$sql .=" sum(me_iine.sexy) as s_sexy";
	$sql .=" FROM `me_iine`";
	$sql .=" LEFT JOIN `me_making` ON me_iine.i_card_id=me_making.making_id";

	$sql .=" WHERE i_host_id='{$host_id}'";
	$sql .=" AND me_making.del='0'";
	$sql .=" GROUP BY i_host_id";

	$res = mysqli_query($mysqli,$sql);
	while($dat0 = mysqli_fetch_assoc($res)){
		$pritty_all =$dat0["s_pritty"];
		$smart_all	=$dat0["s_smart"];
		$funny_all	=$dat0["s_funny"];
		$sexy_all	=$dat0["s_sexy"];
	}

	$sql ="SELECT *	FROM `me_making`";
	$sql.=" LEFT JOIN `reg` ON me_making.user_id=reg.id";
	$sql.=" WHERE `me_making`.`del`='0'";
	$sql.=" AND me_making.user_id='{$host_id}'";
	$sql.=" ORDER BY me_making.making_id DESC";
	$sql.=" LIMIT 21";

	$result = mysqli_query($mysqli,$sql);
	while($dat2 = mysqli_fetch_assoc($result)){
		$dat[$d]=$dat2;

		$dat[$d]["img_url"]	=$card_url.$dat2["img2"];
		$dat[$d]["mdate"]	=substr($dat2["makedate"],5,2)."/".substr($dat2["makedate"],8,2)."　".substr($dat2["makedate"],11,2).":".substr($dat2["makedate"],14,2);
		$dat[$d]["tl"]		=get_after($dat2["makedate"]);

		$sql ="SELECT * FROM `me_iine`";
		$sql.=" WHERE `i_card_id`='{$dat2['making_id']}'";
		$sql.=" AND (pritty>0 OR smart>0 OR funny>0 OR sexy>0)";
		$result3 = mysqli_query($mysqli,$sql);
		while($dat3 = mysqli_fetch_assoc($result3)){
			$dat[$d]["pritty"]	+=$dat3["pritty"];
			$dat[$d]["smart"]	+=$dat3["smart"];
			$dat[$d]["funny"]	+=$dat3["funny"];
			$dat[$d]["sexy"]	+=$dat3["sexy"];

			if($dat3["i_user_id"] == $user["id"]){

				if($dat3["pritty"]>0){
					$dat[$d]["mysel"]	="pritty";
					$dat[$d]["minus"]	=$dat3["pritty"];

				}elseif($dat3["smart"]>0){
					$dat[$d]["mysel"]	="amart";
					$dat[$d]["minus"]	=$dat3["smart"];
					
				}elseif($dat3["funny"]>0){
					$dat[$d]["mysel"]	="funny";
					$dat[$d]["minus"]	=$dat3["funny"];

				}elseif($dat3["sexy"]>0){
					$dat[$d]["mysel"]	="sexy";
					$dat[$d]["minus"]	=$dat3["sexy"];
				}
			}
		}


		$dat[$d]["iine"]=$dat[$d]["pritty"]+$dat[$d]["smart"]+$dat[$d]["funny"]+$dat[$d]["sexy"];



		$sql="SELECT count(c_card_id) as cnt, c_card_id FROM me_cheer";
		$sql.=" WHERE del=0";
		$sql.=" AND c_card_id='{$dat2['making_id']}'";
		$sql.=" AND com IS NOT NULL";
		$sql.=" GROUP BY c_card_id";

		$result2 = mysqli_query($mysqli,$sql);
		while($cheer0 = mysqli_fetch_assoc($result2)){
			$dat[$d]["cheer_ct"]=$cheer0["cnt"];
		}
		$d++;
	}
	
	$sql4 ="SELECT * FROM me_fav";
	$sql4.=" WHERE fav_host_id='{$host_id}'";
	$sql4.=" AND fav_set>0";

	$result4 = mysqli_query($mysqli,$sql4);
	while($fav0 = mysqli_fetch_assoc($result4)){
		$refav_all++;
		if($fav0["fav_user_id"]==$user["id"]){
			$fav_ck=1;
		}
	}

	$sql4 ="SELECT count(fav_id) as refav FROM me_fav";
	$sql4.=" WHERE fav_user_id='{$host_id}'";
	$sql4.=" AND fav_set>0";

	$result4 = mysqli_query($mysqli,$sql4);
	$fav1 = mysqli_fetch_assoc($result4);
	$fav_all=$fav1["refav"];




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
<link rel="stylesheet" href="./css/profile.css?_<?=date("YmdHi")?>">
<script src="./js/jquery-3.4.1.min.js"></script>
<script src="./js/jquery-ui.min.js"></script>
<script src="./js/jquery.ui.touch-punch.min.js"></script>
<script src="./js/first.js"></script>
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
var Date_30	='<?=$date_30?>';
var Last_card	=0;


$(function(){ 
<?if($jump_id){?>
	Img_id	= '<?=$jump_id?>';
	MySel	= '<?=$iine_kind?>';
	Minus	= '<?=$iine_pts?>';
	Chg		=0;
	Own		= '<?=$host_id?>';
	Pict	= '<?=$sub_img?>';

	Pritty	= '<?=$e_pritty+0?>';
	Smart	= '<?=$e_smart+0?>';
	Funny	= '<?=$e_funny+0?>';
	Sexy	= '<?=$e_sexy+0?>';

	AllIine	= '<?=$e_pritty+$e_smart+$e_funny+$e_sexy+0?>';
	Mdate	='<?=$mdate?>';
	Img_Name=`<?=$row2["reg_name"]?>`;

	$('#e_pritty').text(Pritty);
	$('#e_smart').text(Smart);
	$('#e_funny').text(Funny);
	$('#e_sexy').text(Sexy);

	$('#tmpl').attr({'src':Img_Url});
	$('.p_name').text(Img_Name);
	$('.p_date').text(Mdate);
	$('#p_pict').attr('src',Pict);

	$('.p_page').show();

	if(Own == User_id){
		$('.p_page_msg_a').addClass('iine_my_a');
		$('.p_page_msg_c').addClass('iine_my_c2');
		$('.set_cheer').addClass('cheer_no');

	}else if(MySel){	
		$('#'+MySel).addClass('ii_'+MySel);
		$('#e_'+MySel).addClass('iine_my_c1');
	}

	$('.p_cheer_cld').hide();
	$('.prof_table').hide();
	$('.main').hide();
<?}?>

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
<?include_once("./x_head.php")?>
<div class="main">
	<div class="prof_main">
	<img src="<?=$host_face?>" class="prof_img">
		<div class="prof_name"><?=$user_ck["reg_name"]?><?if($host_id !=$user["id"]){?><div class="prof_fav s0 <?if($fav_ck==1){?>prof_fav_on<?}?>">★</div><? } ?></div>
		<div class="prof_iine p1"><span class="iine_icon icon_img"></span><span class="iine_no"><?=$pritty_all+0?></span></div>
		<div class="prof_iine p2"><span class="iine_icon icon_img"></span><span class="iine_no"><?=$smart_all+0?></span></div>
		<div class="prof_iine p3"><span class="iine_icon icon_img"></span><span class="iine_no"><?=$funny_all+0?></span></div>
		<div class="prof_iine p4"><span class="iine_icon icon_img"></span><span class="iine_no"><?=$sexy_all+0?></span></div>

		<div class="prof_lv">LV:<span class="item_no"><?=$prof_lv+0?></span></div>
		<div class="prof_follow">Follow:<span class="item_no"><?=$fav_all+0?></span></div>
		<div class="prof_follower">Follower:<span id="p_fav" class="item_no"><?=$refav_all+0?></span></div>
		
		<div class="prof_out s1 <?if($dat_p["twitter"]){?>p_twitter<?}else{?>p_off<?}?>"></div>
		<div class="prof_out s2 <?if($dat_p["insta"]){?>p_insta<?}else{?>p_off<?}?>"></div>
		<div class="prof_out s3 <?if($dat_p["cosp"]){?>p_cosp<?}else{?>p_off<?}?>"></div>

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

	<div class="index_box pbox">
		<?for($n=0;$n<$d;$n++){?>
		<?if($n>=20){break;}?>	
			<div id="f<?=$dat[$n]["making_id"]?>" class="index_frame">
				<input type="hidden" name="own" value="<?=$dat[$n]["user_id"]+0?>">
				<input type="hidden" name="pict" value="<?=$host_face?>">
				<input type="hidden" name="mdate" value="<?=$dat[$n]["mdate"]?>">
				<input type="hidden" name="cheer_ct" value="<?=$dat[$n]["cheer_ct"]+0?>">
				<input type="hidden" name="alert" value="<?=$dat[$n]["alert"]+0?>">

				<input id="mm<?=$dat[$n]["making_id"]?>" type="hidden" name="mysel" value="<?=$dat[$n]["mysel"]?>">
				<input id="mi<?=$dat[$n]["making_id"]?>" type="hidden" name="minus" value="<?=$dat[$n]["minus"]+0?>">
				<input id="pp<?=$dat[$n]["making_id"]?>" type="hidden" name="pritty" value="<?=$dat[$n]["pritty"]+0?>">
				<input id="ss<?=$dat[$n]["making_id"]?>" type="hidden" name="smart" value="<?=$dat[$n]["smart"]+0?>">
				<input id="ff<?=$dat[$n]["making_id"]?>" type="hidden" name="funny" value="<?=$dat[$n]["funny"]+0?>">
				<input id="xx<?=$dat[$n]["making_id"]?>" type="hidden" name="sexy" value="<?=$dat[$n]["sexy"]+0?>">
				<input id="al<?=$dat[$n]["making_id"]?>" type="hidden" name="all" value="<?=$dat[$n]["iine"]+0?>">

				<div class="album_prof">
				<span class="album_time"><?=$dat[$n]["tl"]?></span>
				<span class="album_iine"><span class="album_iine_i"></span><?=$dat[$n]["iine"]+0?></span>
				<span class="album_comm"><span class="album_comm_i"></span><?=$dat[$n]["cheer_ct"]+0?></span>
				</div>
				<img src="<?=$dat[$n]["img_url"]?>" class="index_img" alt="<?=$dat[$n]["reg_name"]?>">
			</div>
		<? } ?>
		<?if($n>=20){?><div id="next_<?=$last_card?>" class="next">続きを読む</div><? } ?>

		<?if($n==0){?>
			<div class="no_card">作成された名刺はまだありません</div>
		<? } ?>
	</div>
</div>

<div class="p_page">
	<div id="p_page_out" class="back"><span class="icon_img"></span></div>
	<span class="p_date"></span>

	<div id="p_page_alert" class="alert">
		<span class="p_icon icon_img"></span>
	</div>
	<img id="tmpl" class="p_page_img">

	<div class="box_iine">
	<img id="p_pict" class="box_iine_face">
	<div id="p_page_prof" class="box_name"><span class="p_name"></span></div>
	<div id="p_page_comment" class="box_comm"><span class="p_icon2 icon_img"></span><span class="p_icon_comment">応援</span><span id="cheer_ct"></span></div>

	<div id="pritty" class="p_page_msg_a ii_1">
		<span class="icon_img p_page_icon"></span>
		<span class="p_page_msg_b">カワイイ</span>
		<span id="e_pritty" class="p_page_msg_c"></span>
	</div>

	<div id="smart" class="p_page_msg_a ii_2">
		<span class="icon_img p_page_icon"></span>
		<span class="p_page_msg_b">イケメン</span>
		<span id="e_smart" class="p_page_msg_c"></span>
	</div>

	<div id="funny" class="p_page_msg_a ii_3">
		<span class="icon_img p_page_icon"></span>
		<span class="p_page_msg_b">ユニーク</span>
		<span id="e_funny" class="p_page_msg_c"></span>
	</div>

	<div id="sexy" class="p_page_msg_a ii_4">
		<span class="icon_img p_page_icon"></span>
		<span class="p_page_msg_b">セクシー</span>
		<span id="e_sexy" class="p_page_msg_c"></span>
	</div>
	</div>
	<div class="p_cheer">
		<div class="cheer_list"></div>
		<div class="set_cheer"><span class="icon_img"></span>応援！</div>
	</div>
</div>



<form id="jump_p" action="./profile.php" method="post">
	<input id="jump_id" type="hidden" name="host" value="">	
</form>

<div class="pop01">
	<div class="pop01_a">
		<div class="pop01_a1">
			<textarea class="pop01_c" name=""></textarea>
			<div id="yes_1" class="btn c2">通報</div>　
			<div id="no_1" class="btn c1">取消</div>
		</div>
		<div class="pop01_a2">
			通報された投稿はスタッフが確認を行い、不適切と判断されましたら削除されます。<br>
			通報された投稿が必ずしも削除されるわけではありません。<br>
			<span style="font-weight:600;">削除ガイドライン</span><br>
			・公序良俗に反する画像<br>
			・著作権を侵害していると思われる画像<br>
			・個人情報に抵触していると思われる画像<br>
		</div>
	</div>
	<div class="pop01_e">
		通報しました。<br><br>
		<div class="btn c1">戻る</div>
	</div>
</div>

<div class="pop02">
	自分の投稿には評価を付けられません。
</div>
<div class="pop03">
	「評価」をすると応援コメントを送れます。
</div>
<div class="pop04">
	すでに通報されています。
</div>
<div class="pop05">
	自分の投稿は通報できません。
</div>
<div class="pop06">
	自分の投稿には応援できません。
</div>
<div class="pop07">
	<div class="pop07_a">
		<textarea id="p_cheer_box" class="p_cheer_box" name="p_cheer_box"></textarea>
		<div id="p_cheer_sub" class="btn c2 ps1" style="width:17.5vw;">応援</div> 
		<div id="no_1" class="btn c1  ps2" style="width:17.5vw;">取消</div> 
		<div id="p_cheer_del" class="btn c3 ps3">消去</div>
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
</body>
</html>
