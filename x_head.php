<?
if($nowpage!=2){
	$sql ="SELECT count(notice_id) as cnt FROM `me_notice`";
	$sql .=" WHERE n_target_id='{$user["id"]}'";
	$sql .=" AND `del`='0'";
	$sql .=" AND `check_date`='0000-00-00 00:00:00'";

	$datn1	= mysqli_query($mysqli,$sql);
	$datn2	= mysqli_fetch_assoc($datn1);
	if($datn2["cnt"]>20) $datn2["cnt"]="20+";
}
?>
<div class="blind">
<div class="blind_msg">
ERROR!
</div>
</div>
<div class="pc_only">
	<img src="./img/top.png" style="width:700px;"><br>
	<div class="pc_box" style="font-size:14px;">
		こちらはスマホ専用サイトです。<br>
		PC・タブレットではご利用いただけません。<br>
	</div>
</div>
<div class="sp_only">
	<div class="head_s">		</div>
	<div class="head">	
		<div class="head_mymenu">
			<div class="mymenu_a"></div>
			<div class="mymenu_b"></div>
			<div class="mymenu_c"></div>
		</div>	
		<div  class="head_c <?if($nowpage==1){?> top_b_sel<?}?>">
			<a href="index.php" class="head_l <?if($nowpage==1){?> top_l_sel<?}?>"><span class="head_icon icon_img"></span><span class="head_com">TOP</span></a>
		</div>
		<div  class="head_c <?if($nowpage==2){?> top_b_sel<?}?>">
			<a href="mydata.php" class="head_l <?if($nowpage==2){?> top_l_sel<?}?>"><span class="head_icon icon_img"></span><span class="head_com">Album</span><?if($datn2["cnt"]){?><span class="head_cnt"><?=$datn2["cnt"]?></span><?}?></a>
		</div>
		<div  class="head_c <?if($nowpage==3){?> top_b_sel<?}?>">
			<a href="making.php" class="head_l <?if($nowpage==3){?> top_l_sel<?}?>"><span class="head_icon icon_img"></span><span class="head_com">Making</span></a>
		</div>
		<div  class="head_c <?if($nowpage==4){?> top_b_sel<?}?>">
			<a href="config.php" class="head_l <?if($nowpage==4){?> top_l_sel<?}?>"><span class="head_icon icon_img"></span><span class="head_com">Config</span></a>
		</div>
	</div>

	<div class="mypage">
		<a href="./config.php"><img id="my_face" src="<?=$user_face?>?t=<?=time()?>"></a>
		<div class="mypage_prof">	
			<span class="mypage_name">
			<span class="mypage_sex sex<?=$user["reg_sex"]?>"><?=$sex_mark[$user["reg_sex"]]?></span>
			<?=$user["reg_name"]?>
			</span><br>
			<span class="user_level">LV：<span class="mypage_level"><?=$lv?></span></span>　
			<span class="user_level">Exp：<span class="mypage_exp"><?=$exp?></span><br>
		</div>
		<div class="mypage_prof2">	
			<a href="./mydata.php" class="mypage_prof_in">フォロー数<span class="mypage_prof_p"><?=$user["s_favd"]+0?></span></a><br>
			<a href="./mydata.php" class="mypage_prof_in">フォロワー数<span class="mypage_prof_p"><?=$user["s_fav"]+0?></span></a><br>
		</div>
		<div class="mypage_iine_box">
			<div class="mypage_iine" style="color:#0000d0"><span class="icon_img"></span> 応援<span class="mypage_iine_p"><?=$user["s_cheer"]+0?></span></div>
			<div class="mypage_iine"><span class="icon_img"></span> カワイイ<span class="mypage_iine_p"><?=$user["s_pritty"]+0?></span></div>
			<div class="mypage_iine"><span class="icon_img"></span> イケメン<span class="mypage_iine_p"><?=$user["s_smart"]+0?></span></div>
			<div class="mypage_iine"><span class="icon_img"></span> ユニーク<span class="mypage_iine_p"><?=$user["s_funny"]+0?></span></div>
			<div class="mypage_iine"><span class="icon_img"></span> セクシー<span class="mypage_iine_p"><?=$user["s_sexy"]+0?></span></div>
		</div>
		<div class="mypage_box">	
			<a href="./profile.php?e_host=<?=$user_enc_id?>" class="mypage_box_in">My Profile</a>
			<a href="./inpost.php" class="mypage_box_in">ご意見メール</a>
			<a href="./note_index.php" class="mypage_box_in">HELP</a>
			<a href="./index.php?logout=1" class="mypage_box_in">LOG OUT</a>
		</div>
	</div>
