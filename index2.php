<?php
$page_index="top";
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/session.php");
include_once("./library/api.php");
$nowpage=1;
$ex=8;
$d=0;

if($_POST["img_url1"] && $_POST["img_url2"]){
	unlink($dir.'print.php');
	unlink($dir.$_POST["img_url1"]);
	unlink($dir2.$_POST["img_url2"]);

}

if($user["tuto"] == 0){
	$tuto=1;
	$sql="UPDATE reg SET tuto=1 WHERE id='{$user["id"]}'";
	mysqli_query($mysqli,$sql);
}


if($list+0<1) $list=0;
$chg=$_POST["chg"]+0;
$date_30=date("Y-m-d H:i:s",time()-2592000);

if($chg == 1){//■イイネ数順
	$sql ="SELECT *, sum(me_iine.pritty)+sum(me_iine.smart)+sum(me_iine.funny)+sum(me_iine.sexy) as iine FROM `me_making`";
	$sql.=" LEFT JOIN `reg` ON me_making.user_id=reg.id";
	$sql.=" LEFT JOIN `me_iine` ON me_making.making_id=i_card_id";
	$sql.=" LEFT JOIN `me_tmpl` ON me_making.use_tmpl=me_tmpl.tmpl_id";
	$sql.=" WHERE `me_making`.`del`='0'";
	$sql.=" AND makedate>'{$date_30}'";
	$sql.=" GROUP BY me_making.making_id";
	$sql.=" ORDER BY iine DESC";
	$sql.=" LIMIT 21";

}elseif($chg == 3){//■お気に入り
	$sql ="SELECT *, sum(me_iine.pritty)+sum(me_iine.smart)+sum(me_iine.funny)+sum(me_iine.sexy) as iine FROM `me_making`";
	$sql.=" LEFT JOIN `reg` ON me_making.user_id=reg.id";
	$sql.=" LEFT JOIN `me_iine` ON me_making.making_id=i_card_id";
	$sql.=" LEFT JOIN `me_fav` ON me_making.user_id=fav_host_id";
	$sql.=" LEFT JOIN `me_tmpl` ON me_making.use_tmpl=me_tmpl.tmpl_id";
	$sql.=" WHERE `me_making`.`del`='0'";
	$sql.=" AND `me_fav`.`fav_user_id`='{$user["id"]}'";
	$sql.=" AND `me_fav`.`fav_set`='1'";
	$sql.=" GROUP BY me_making.making_id";
	$sql.=" ORDER BY me_making.making_id DESC";
	$sql.=" LIMIT 21";

}elseif($chg == 2){//■コメント最新順
	$sql ="SELECT *, sum(me_iine.pritty)+sum(me_iine.smart)+sum(me_iine.funny)+sum(me_iine.sexy) as iine, max(me_cheer.cheer_date) as cheer_new FROM `me_making`";
	$sql.=" LEFT JOIN `reg` ON me_making.user_id=reg.id";
	$sql.=" LEFT JOIN `me_iine` ON me_making.making_id=i_card_id";
	$sql.=" LEFT JOIN `me_cheer` ON me_making.making_id=me_cheer.c_card_id";
	$sql.=" LEFT JOIN `me_tmpl` ON me_making.use_tmpl=me_tmpl.tmpl_id";
	$sql.=" WHERE `me_making`.`del`='0'";
	$sql.=" GROUP BY me_making.making_id";
	$sql.=" ORDER BY cheer_new DESC";
	$sql.=" LIMIT 21";


}else{
/*
	$sql ="SELECT *, sum(me_iine.pritty)+sum(me_iine.smart)+sum(me_iine.funny)+sum(me_iine.sexy)  as iine, max(me_cheer.cheer_date) as cheer_new, max(me_making.making_id) as mid FROM `me_making`";
	$sql.=" LEFT JOIN `reg` ON me_making.user_id=reg.id";
	$sql.=" LEFT JOIN `me_iine` ON me_making.making_id=i_card_id";
	$sql.=" LEFT JOIN `me_cheer` ON me_making.making_id=me_cheer.c_card_id";
	$sql.=" LEFT JOIN `me_tmpl` ON me_making.use_tmpl=me_tmpl.tmpl_id";
	$sql.=" WHERE `me_making`.`del`='0'";
//	$sql.=" GROUP BY me_making.making_id";
	$sql.=" GROUP BY me_making.user_id";
	$sql.=" ORDER BY me_making.making_id DESC";
	$sql.=" LIMIT 21";
*/
	$sql ="SELECT max(makedate) as mdate, user_id, max(making_id) as mid, FROM `me_making`";
	$sql.=" WHERE `del`='0'";
//	$sql.=" GROUP BY me_making.making_id";
	$sql.=" GROUP BY user_id";
	$sql.=" ORDER BY making_id DESC";
	$sql.=" LIMIT 21";
}

//print($sql);

$result = mysqli_query($mysqli,$sql);
while($dat2 = mysqli_fetch_assoc($result)){

	$sql ="SELECT * FROM `reg`";
	$sql.=" WHERE `id='{$dat2["user_id"]}'";

	$sql ="SELECT sum(me_iine.pritty)+sum(me_iine.smart)+sum(me_iine.funny)+sum(me_iine.sexy)  as iine, max(me_cheer.cheer_date) as cheer_new FROM `me_iine`";
	$sql.=" WHERE `i_card_id='{$dat2["making_id"]}'";

	$sql ="SELECT * FROM `me_cheer`";
	$sql.=" WHERE `c_card_id='{$dat2["making_id"]}'";

	for($n=0;$n<4;$n++){
		$tmp_key=substr($dat2["user_id"],$n*2,2);
		$tmp_enc[$n]=$enc[$tmp_key];
	}

	$list_enc=$tmp_enc[0].$tmp_enc[3].$tmp_enc[1].$tmp_enc[2].$tmp_enc[3].$tmp_enc[2];
	$main_img	="./myalbum/{$tmp_enc[3]}/{$list_enc}/{$tmp_enc[2]}{$tmp_enc[3]}/{$dat2["img"]}";
	$sub_img	="./myalbum/{$tmp_enc[3]}/{$list_enc}/{$tmp_enc[1]}{$tmp_enc[3]}/{$dat2["img2"]}";

	if(file_exists($main_img) && file_exists($sub_img)){
		if($dat2["cate01"] == 1) $tag[$d][].="女子";
		if($dat2["cate02"] == 1) $tag[$d][].="男子";
		if($dat2["cate03"] == 1) $tag[$d][].="和風";
		if($dat2["cate04"] == 1) $tag[$d][].="自然";
		if($dat2["cate05"] == 1) $tag[$d][].="季節";
		if($dat2["cate06"] == 1) $tag[$d][].="厨二";
		if($dat2["cate07"] == 1) $tag[$d][].="限定";
		$tag_c[$d]		=count($tag[$d]);
		$tag_id[$d]		="tag".$dat2["use_tmpl"];
		$tag_code[$d]	=$dat2["tmpl_code"];

//print($dat[$d]["cate01"]."◇".$dat[$d]["cate"]."<br>\n");

		$dat[$d]=$dat2;

		$dat[$d]["mdate"]=substr($dat2["makedate"],5,2)."/".substr($dat2["makedate"],8,2)." ".substr($dat2["makedate"],11,2).":".substr($dat2["makedate"],14,2);
		$dat[$d]["img_url"]	=$sub_img;
		$dat[$d]["tl"]	=get_after($dat2["makedate"]);

		for($n=0;$n<4;$n++){
			$f_tmp_key=substr($dat2["user_id"],$n*2,2);
			$f_tmp_enc[$n]=$enc[$f_tmp_key];
		}
	
		$f_list_enc=$f_tmp_enc[0].$f_tmp_enc[3].$f_tmp_enc[1].$f_tmp_enc[2].$f_tmp_enc[3].$f_tmp_enc[2];
		$f_tmp=substr("0".$f_tmp_key+$dat2["reg_pic"],-2,2);
	
		if($dat2["reg_pic"]>0){
			$dat[$d]["face"]	= "./myalbum/{$f_tmp_enc[3]}/{$f_list_enc}/{$f_tmp_enc[3]}{$f_tmp_enc[2]}/{$enc[$f_tmp]}.jpg";
		}else{
			$dat[$d]["face"]	= "./img/noimage{$dat2["reg_sex"]}.jpg";
		}
	
		$sql ="SELECT * FROM `me_iine`";
		$sql.=" WHERE `i_card_id`='{$dat2['making_id']}'";
		$sql.=" AND (pritty>0 OR smart>0 OR funny>0 OR sexy>0)";
		$result3 = mysqli_query($mysqli,$sql);
		while($dat3 = mysqli_fetch_assoc($result3)){
			$pritty[$d]	+=$dat3["pritty"];
			$smart[$d]	+=$dat3["smart"];
			$funny[$d]	+=$dat3["funny"];
			$sexy[$d]	+=$dat3["sexy"];

			if($dat3["i_user_id"] == $user["id"]){

				if($dat3["pritty"]>0){
					$mysel[$d]	="pritty";
					$minus[$d]	=$dat3["pritty"];

				}elseif($dat3["smart"]>0){
					$mysel[$d]	="smart";
					$minus[$d]	=$dat3["smart"];
					
				}elseif($dat3["funny"]>0){
					$mysel[$d]	="funny";
					$minus[$d]	=$dat3["funny"];

				}elseif($dat3["sexy"]>0){
					$mysel[$d]	="sexy";
					$minus[$d]	=$dat3["sexy"];
				}
			}
		}

		$sql="SELECT * FROM me_cheer";
		$sql.=" LEFT JOIN `reg` ON me_cheer.c_user_id=reg.id";
		$sql.=" WHERE c_card_id='{$dat2["making_id"]}'";
		$sql.=" AND `com`!=''";
		$sql.=" AND del=0";
		$sql.=" ORDER BY `cheer_date` DESC";

		$result4 = mysqli_query($mysqli,$sql);
		$ch=0;

		while($dat4 = mysqli_fetch_assoc($result4)){
			$cheer[$ch]	=$dat4;
			$cheer_all[$ch]++;

			for($n=0;$n<4;$n++){
				$f_tmp_key=substr($dat4["c_user_id"],$n*2,2);
				$f_tmp_enc[$n]=$enc[$f_tmp_key];
			}
		
			$f_list_enc=$f_tmp_enc[0].$f_tmp_enc[3].$f_tmp_enc[1].$f_tmp_enc[2].$f_tmp_enc[3].$f_tmp_enc[2];
			$f_tmp=substr("0".$f_tmp_key+$dat4["reg_pic"],-2,2);
		
			if($dat4["reg_pic"]>0){
				$cheer[$ch]["face"]	= "./myalbum/{$f_tmp_enc[3]}/{$f_list_enc}/{$f_tmp_enc[3]}{$f_tmp_enc[2]}/{$enc[$f_tmp]}.jpg";
			}else{
				$cheer[$ch]["face"]	= "./img/noimage{$dat4["reg_sex"]}.jpg";
			}
			$ch++;
		}
		$dat[$d]["cheer_ct"]=$ch;
		$sql4 ="SELECT al_card_id FROM me_alert";
		$sql4.=" WHERE al_card_id='{$dat2["making_id"]}'";
		$sql4.=" AND al_user_id='{$user["id"]}'";
		$sql4.=" LIMIT 1";


		$result4 = mysqli_query($mysqli,$sql4);
		if($dat4 = mysqli_fetch_assoc($result4)){
			$dat[$d]["alert"]=1;	
		}
		$d++;
	}
}
/*
foreach($dat[0] as $a1 => $a2){
print($a1."■".$a2."<br>\n");
}
*/
$last_card=$dat[19]['making_id'];
if(!$_SESSION){
$t_re=$_SERVER["HTTP_REFERER"];
$t_ua=$_SERVER['HTTP_USER_AGENT'];
$t_ip=$_SERVER["REMOTE_ADDR"];
if(!$t_re) $t_re="null";
if(!$t_ua) $t_ua="null";
$log_date = date("Y-m-d H:i:s");
$sql="INSERT INTO me_alllog(`log_date`,`log_ref`,`log_ua`,`log_ip`) VALUES('{$log_date}','{$t_re}','{$t_ua}','{$t_ip}')";
mysqli_query($mysqli,$sql);
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>写真名刺制作サイト「OnlyMe」</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
<meta name="description" content="PC不要、住所不要、スマホで作成、コンビニで印刷。手軽で簡単な写真名刺制作サイトです。">
<meta name="keywords" content="写真名刺,コスプレ,画像修正,onlyme,名刺作成,無料,簡単">

<link rel="canonical" href="https://onlyme.fun/">
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
	var VwBase =$(window).width()/100;
	var VhBase =$(window).height()/100;
	var ChBase =(VhBase*100)-(VwBase*101);
	var User_id =<?=$user["id"]+0?>;
	var iine_Pt =<?=$iine_pt+0?>;
	var NextCk=0;
	var Chg =<?=$chg+0?>;
	var Date_30 =<?=$date_30+0?>;
	var Last_card =<?=$last_card+0?>;

$(function(){ 

<?if($tuto ==1){?>
		$('.tuto').delay(500).fadeIn(500);
<?}?>
	<?if($chg == 1){?>
		$('.h1_main_slide').text('注目');
		$('.h1_select').text('評価数順(過去30日)');

	<?}else if($chg == 2){?>
		$('.h1_main_slide').text('話題');
		$('.h1_select').text('最新応援順');

	<?}else if($chg == 3){?>
		$('.h1_main_slide').text('フォロー');
		$('.h1_select').text('フォローしているユーザー');

	<?}else{?>
		$('.h1_main_slide').text('新着');
		$('.h1_select').text('新規名刺作成順');
	<?}?>
		$('#tuto_pg2').hide();
});
</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-146438289-2"></script>
<script data-ad-client="ca-pub-8647163255903836" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());
	gtag('config', 'UA-146438289-2');
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
<style>
</style>
</head>
<body class="body">
<?if(!$_SESSION){?>
<?include_once("./onlyme.php")?>

<?}else{?>
<?include_once("./x_head.php")?>
<div class="main">
<div style="height:0.5vw;width:90vw">　</div/>
	<div class="index_info">
		<p class="p_toi">印刷の仕様が変更になりました。詳細は<a href="./note_index.php?note=42">HELP</a>をご参照下さい</p>
		<p class="p_toi">お問い合わせ、不具合報告は<a href="./inpost.php">ご意見メール</a>よりお願いします</p>
	</div/>

	<h1 class="h1">
		<span class="h1_title">みんなの名刺</span>
		<span class="h1_main_slide"></span>
		<span class="h1_sub_slide">
		<span id="sel_0" class="h1_item">新着</span>
		<span id="sel_1" class="h1_item">注目</span>
		<span id="sel_2" class="h1_item">話題</span>
		<span id="sel_3" class="h1_item">フォロー</span>
		</span>
	</h1>
	<div class="h1_select">登録された順番です</div/>
	<div class="index_box">
		<?for($n=0;$n<$d;$n++){?>
		<?if($n>=20){break;}?>	
			<div id="f<?=$dat[$n]["making_id"]?>" class="index_frame">
				<img src="<?=$dat[$n]["img_url"]?>" class="index_img" alt="<?=$dat[$n]["reg_name"]?>">

				<input type="hidden" name="own" value="<?=$dat[$n]["user_id"]+0?>">
				<input type="hidden" name="pict" value="<?=$dat[$n]["face"]?>">
				<input type="hidden" name="mdate" value="<?=$dat[$n]["mdate"]?>">
				<input type="hidden" name="cheer_ct" value="<?=$dat[$n]["cheer_ct"]?>">
				<input type="hidden" name="alert" value="<?=$dat[$n]["alert"]+0?>">
				<input id="mm<?=$dat[$n]["making_id"]?>" type="hidden" name="mysel" value="<?=$mysel[$n]?>">
				<input id="mi<?=$dat[$n]["making_id"]?>" type="hidden" name="minus" value="<?=$minus[$n]+0?>">
				<input id="pp<?=$dat[$n]["making_id"]?>" type="hidden" name="pritty" value="<?=$pritty[$n]+0?>">
				<input id="ss<?=$dat[$n]["making_id"]?>" type="hidden" name="smart" value="<?=$smart[$n]+0?>">
				<input id="ff<?=$dat[$n]["making_id"]?>" type="hidden" name="funny" value="<?=$funny[$n]+0?>">
				<input id="xx<?=$dat[$n]["making_id"]?>" type="hidden" name="sexy" value="<?=$sexy[$n]+0?>">
				<input id="al<?=$dat[$n]["making_id"]?>" type="hidden" name="all" value="<?=$iine[$n]+0?>">
				<input type="hidden" name="cate_id" value="<?=$tag_id[$n]?>">
				<input type="hidden" name="cate_code" value="<?=$tag_code[$n]?>">

<?for($t=0;$t<$tag_c[$n];$t++){?>
				<input type="hidden" name="cate<?=$t?>" value="<?=$tag[$n][$t]?>">
<?}?>
				<table class="index_frame_ttl">
					<tr>
						<td rowspan="2" class="ttl_1"><img id="h_face<?=$n?>" src="<?=$dat[$n]["face"]?>" class="ttl_img" alt="face"></td>
						<td class="ttl_2"><?=$dat[$n]["tl"]?></td>
						<td class="ttl_3">
						<div class="ttl_comm">
						<span class="icon_img comm_icon"></span>
						<span class="comm_cnt"><?=$dat[$n]["iine"]+0?></span>
						</div/>
						</td>
					</tr>
					<tr>
						<td colspan="2" class="ttl_4"><?=$dat[$n]["reg_name"]?></td>
					</tr>
				</table>	
			</div/>
		<? } ?>
		<div id="next_<?=$last_card?>" class="next">続きを見る</div/>
	</div/>
</div/>


<div class="p_page">
	<div id="p_page_out" class="back"><span class="icon_img"></span></div/>
	<div id="p_page_info" class="info">
		<span class="icon_img"></span>
	</div/>
	<div class="info_list">
	<div class="info_list_code">T00001</div/>
	<div class="info_list_flex"></div/>
	<a href="" class="info_list_btn">このデザインを使う</a>
	</div/>
	
	<span class="p_date"></span>
	<div id="p_page_alert" class="alert">
		<span class="p_icon icon_img"></span>
	</div/>

	<img id="tmpl" class="p_page_img">
	<div class="box_iine">
	<img id="p_pict" class="box_iine_face">
	<div id="p_page_prof" class="box_name"><span class="p_name"></span></div/>
	<div id="p_page_comment" class="box_comm"><span class="p_icon2 icon_img"></span><span class="p_icon_comment">応援</span><span id="cheer_ct"></span></div/>

	<div id="pritty" class="p_page_msg_a ii_1">
		<span class="icon_img p_page_icon"></span>
		<span class="p_page_msg_b">カワイイ</span>
		<span id="e_pritty" class="p_page_msg_c"></span>
	</div/>

	<div id="smart" class="p_page_msg_a ii_2">
		<span class="icon_img p_page_icon"></span>
		<span class="p_page_msg_b">イケメン</span>
		<span id="e_smart" class="p_page_msg_c"></span>
	</div/>

	<div id="funny" class="p_page_msg_a ii_3">
		<span class="icon_img p_page_icon"></span>
		<span class="p_page_msg_b">ユニーク</span>
		<span id="e_funny" class="p_page_msg_c"></span>
	</div/>

	<div id="sexy" class="p_page_msg_a ii_4">
		<span class="icon_img p_page_icon"></span>
		<span class="p_page_msg_b">セクシー</span>
		<span id="e_sexy" class="p_page_msg_c"></span>
	</div/>
	</div/>
	<div class="p_cheer">
		<div class="cheer_list"></div/>
		<div class="set_cheer"><span class="icon_img"></span>応援！</div/>
	</div/>
</div/>


<div class="pop01">
	<div class="pop01_a">
		<div class="pop01_a1">
			<span class="pop01_ttl">違反通報</span>
			<textarea class="pop01_c" name="textarea"></textarea>
			<div id="yes_1" class="btn c2">通報</div/>　
			<div id="no_1" class="btn c1">取消</div/>
		</div/>
		<div class="pop01_a2">
			通報された投稿はスタッフが確認を行い、不適切と判断されましたら削除されます。<br>
			通報された投稿が必ずしも削除されるわけではありません。<br>
			<span style="font-weight:600;">削除ガイドライン</span><br>
			・公序良俗に反する画像<br>
			・著作権を侵害していると思われる画像<br>
			・個人情報に抵触していると思われる画像<br>
		</div/>
	</div/>
	<div class="pop01_e">
		通報しました。<br><br>
		<div class="btn c1">戻る</div/>
	</div/>
</div/>

<div class="pop02">自分の投稿には評価を付けられません。</div/>
<div class="pop03">「評価」をすると応援コメントを送れます。</div/>
<div class="pop04">すでに通報されています。</div/>
<div class="pop05">自分の投稿は通報できません。</div/>
<div class="pop06">自分の投稿には応援できません。</div/>

<div class="pop07">
	<div class="pop07_a">
		<textarea id="p_cheer_box" class="p_cheer_box" name="p_cheer_box"></textarea>
		<div id="p_cheer_sub" class="btn c2 ps1" style="width:17.5vw;">応援</div/> 
		<div id="no_1" class="btn c1  ps2" style="width:17.5vw;">取消</div/> 
		<div id="p_cheer_del" class="btn c3 ps3">消去</div/>
	</div/>
</div/>
<div class="tuto">
	<div class="tuto_box">
		<span class="tuto_wel">ようこそ <?=$user["reg_name"]?>様</span>
		<div id="tuto_pg1" class="tuto_pg">
			<img src="./img/tuto/tuto_01.png" class="tuto_img"><br>
			まずはMENU「config」から、名刺データを設定してね。<br>
		</div/>
		<div id="tuto_pg2" class="tuto_pg">
			<img src="./img/tuto/tuto_02.png" class="tuto_img"><br>
			名刺の作成はMENU「making」から行えます。<br>
		</div/>
	</div/>
</div/>
<form id="jump_p" action="./profile.php" method="post">
	<input id="jump_id" type="hidden" name="host" value="">	
</form>
<form id="chg_jump" action="./index.php" method="post">
	<input id="chg" type="hidden" name="chg" value="">
</form>
<? } ?>
<?include_once("./x_foot.php")?>
