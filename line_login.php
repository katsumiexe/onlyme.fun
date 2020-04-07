<?
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/no_session.php");
include_once("./library/lib_regist.php");
/*
https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=1653949496&redirect_uri=https%3a%2f%2fonlyme.fun%2fline_login.php&state=1sdf&scope=profile%20openid%20email
*/


$yy		=$_POST["yy"];
$out	=$_POST["out"];
if(!$yy) $yy=2000;
if(!$out){
	$dat_e = array(
	  'grant_type'    => 'authorization_code',
	  'code'          => $_GET['code'],
	  'redirect_uri'  => 'https://onlyme.fun/line_login.php',
	  'client_id'     => '1653949496',
	  'client_secret' => '8602dc9eba8e1901830af09a045f0711'
	);

	$url = "https://api.line.me/oauth2/v2.1/token";
	$content = http_build_query($dat_e);
	$dat_e2 = array(
		'http' => array(
			'header' =>"Content-Type: application/x-www-form-urlencoded",
			'method' =>'POST',
			'content'=>$content
		)
	);	

	$e_token = file_get_contents($url,false, stream_context_create($dat_e2));
	$e_login =json_decode($e_token,true);
	$id_token		=$e_login["id_token"];

/*
	$dat_d = array(
		'id_token'	=>$id_token,
		'client_id'	=>'1653949496'
	);

	$url = "https://api.line.me/oauth2/v2.1/verify";
	$content = http_build_query($dat_d);
	$dat_d2 = array(
		'http' => array(
			'header' =>"Content-Type: application/x-www-form-urlencoded",
			'method' =>'POST',
			'content'=>$content
		)
	);

	$d_token = file_get_contents($url,false, stream_context_create($dat_d2));
	$d_login =json_decode($d_token,true);

*/

	$id_decode=explode(".",$id_token);
	$tmp=base64_decode($id_decode[1]);
	$reg_chk=json_decode($tmp,true);

	foreach($reg_chk as $a1 => $a2){
	print("<!--".$a1."□".$a2."-->");
	}

	foreach($e_login as $a1 => $a2){
	print("<!--".$a1."■".$a2."-->");
	}

	if($reg_chk["iss"] =="https://access.line.me" && $reg_chk["aud"] ==1653949496){


//■友達チェック------------------
		$url="https://api.line.me/friendship/v1/status";
		$dat_a2 = array(
			'http' => array(
				'header' =>'Authorization: Bearer {$e_login["access_token"]}',
				'method' =>'POST'
			)
		);

		$a_token = file_get_contents($url, stream_context_create($dat_a2));
		$a_login =json_decode($a_token,true);

//■友達チェック------------------

		$line_name		=$reg_chk["name"];
		$line_picture	=$reg_chk["picture"];
		$line_mail		=$reg_chk["email"];
		$line_id		=$reg_chk["sub"];

		$sql=" SELECT * FROM reg";
		$sql.=" WHERE reg_mail='{$line_mail}' || reg_line='{$line_id}' ORDER BY id DESC LIMIT 1";
		$line_yet = mysqli_query($mysqli,$sql);

		if($l_user_yet = mysqli_fetch_assoc($line_yet)){

			if($l_user_yet["reg_rank"]>10){
				session_save_path('./session/');
				ini_set('session.gc_maxlifetime', 3*60*60); // 3 hours
				ini_set('session.gc_probability', 1);
				ini_set('session.gc_divisor', 100);
				ini_set('session.cookie_secure', FALSE);
				ini_set('session.use_only_cookies', TRUE);
				session_start();
				$_SESSION= $l_user_yet;
				$_SESSION["time"]= time();

				if($line_picture){
					//■------------------------
					for($n=0;$n<4;$n++){	
						$tmp_key=substr($l_user_yet["id"],$n*2,2);
						$tmp_enc[$n]=$enc[$tmp_key];
					}
					//■------------------------
					$user_enc_id=$tmp_enc[0].$tmp_enc[3].$tmp_enc[1].$tmp_enc[2].$tmp_enc[3].$tmp_enc[2];
					$dir="myalbum/{$tmp_enc[3]}/{$user_enc_id}/{$tmp_enc[2]}{$tmp_enc[3]}/";//album
					$dir2="myalbum/{$tmp_enc[3]}/{$user_enc_id}/{$tmp_enc[1]}{$tmp_enc[3]}/";//card
					$dir3="myalbum/{$tmp_enc[3]}/{$user_enc_id}/{$tmp_enc[3]}{$tmp_enc[2]}/";//prof

					mkdir($dir, 0777, TRUE);
					chmod($dir, 0777);

					mkdir($dir2, 0777, TRUE);
					chmod($dir2, 0777);

					mkdir($dir3, 0777, TRUE);
					chmod($dir3, 0777);

					$tmp=substr("0".$tmp_key+1,-2,2);
					$prof_x		=$enc[$tmp].".jpg";
					$link		="./".$dir3.$prof_x;

					$pict= imagecreatefromjpeg($line_picture);
					$img= imagecreatetruecolor(400,400);

					$img_tmp	= getimagesize($line_picture);
					list($tmp_width, $tmp_height, $type, $attr) = $img_tmp;

					ImageCopyResampled($img, $pict, 0, 0, 0, 0, 400, 400, $tmp_width, $tmp_height);
					imagejpeg($img,$link,100);
				}

				if(!$l_user_yet["reg_line"]){
					$app.=" reg_line='{$line_id}',";

				}elseif($l_user_yet["reg_mail"] != $line_mail){
					$app.=" reg_mail='{$line_mail}',";

				}

				if($app){
					$app=substr($app,0,-1);
					$sql ="UPDATE reg SET";
					$sql.=$app;
					$sql.=" WHERE id='{$l_user_yet["id"]}'";
					mysqli_query($mysqli,$sql);
					print($sql);
				}
				$url = 'https://onlyme.fun';
				header('Location: ' . $url, true, 301);
				exit;

			}else{
			/**■LINE退会--------------------*/



			}

		}
	}

}else{
	$send		=$_POST["send"];
	$reg_mail	=$_POST["reg_mail"];

	$submit		=$_POST["submit"];
	$submit_ok	=$_POST["submit_ok"];
	$done		=$_POST["done"];

	$name		=$_POST["name"];
	$mm			=$_POST["mm"];
	$dd			=$_POST["dd"];
	$sex		=$_POST["sex"];
	$state		=$_POST["state"];
	$reg_code	=$_POST["reg_code"];

	$line_id	=$_POST["line_id"];
	$line_picture=$_POST["line_picture"];

	if($out == 2){
		$birth=$yy."-".$mm."-".$dd;
		$sql="INSERT INTO `reg`(`reg_name`,`reg_mail`,`reg_pass`,`reg_style`,`reg_state`,`reg_birth`,`reg_date`,`reg_sex`,`reg_rank`,`reg_code`,`reg_line`)";
		$sql.=" VALUES('{$name}','{$reg_mail}','{$reg_pass}','1','{$state}','{$birth}','{$date}','{$sex}',12,'{$reg_code}','{$line_id}')";
		mysqli_query($mysqli,$sql);

		$tmp_auto=mysqli_insert_id($mysqli)+0;
		$sql_up	 ="INSERT INTO me_prof(`prof_id`,`name`,`mail`)";
		$sql_up	.="VALUES('{$tmp_auto}','{$name}','{$reg_mail}')";
		mysqli_query ($mysqli,$sql_up);
		mb_language("Japanese");
		mb_internal_encoding("UTF-8");

		if($reg_code>0){
			$sql="SELECT making_id, user_id FROM me_making";	
			$sql.=" LEFT JOIN reg ON me_making.user_id=reg.id";	
			$sql.=" WHERE making_id='{$reg_code}'";	
			$sql.=" AND del='0'";	
			$sql.=" AND reg_rank>10";	
			$sql.=" LIMIT 1";	
			
			$re = mysqli_query($mysqli,$sql);
			$de = mysqli_fetch_assoc($re);

			if($de){
				$sql_up	 ="INSERT INTO me_fav(`fav_date`,`fav_user_id`,`fav_host_id`,`fav_set`)";
				$sql_up	.="VALUES('{$date}','{$tmp_auto}', '{$de["user_id"]}', '1')";
				mysqli_query($mysqli,$sql_up);

				$sql_log="INSERT INTO me_notice(`date`,`notice_log`,`n_user_id`,`n_target_id`)";
				$sql_log.=" VALUES('{$date}','6','{$tmp_auto}','{$de["user_id"]}')";
				mysqli_query($mysqli,$sql_log);
			}
		}

		if($line_picture){
			//■------------------------
			for($n=0;$n<4;$n++){	
				$tmp_key=substr($tmp_auto,$n*2,2);
				$tmp_enc[$n]=$enc[$tmp_key];
			}
			//■------------------------

			$user_enc_id=$tmp_enc[0].$tmp_enc[3].$tmp_enc[1].$tmp_enc[2].$tmp_enc[3].$tmp_enc[2];
			$dir="myalbum/{$tmp_enc[3]}/{$user_enc_id}/{$tmp_enc[2]}{$tmp_enc[3]}/";//album
			$dir2="myalbum/{$tmp_enc[3]}/{$user_enc_id}/{$tmp_enc[1]}{$tmp_enc[3]}/";//card
			$dir3="myalbum/{$tmp_enc[3]}/{$user_enc_id}/{$tmp_enc[3]}{$tmp_enc[2]}/";//prof

			mkdir($dir, 0777, TRUE);
			chmod($dir, 0777);

			mkdir($dir2, 0777, TRUE);
			chmod($dir2, 0777);

			mkdir($dir3, 0777, TRUE);
			chmod($dir3, 0777);

			$tmp=substr("0".$tmp_key+1,-2,2);
			$prof_x		=$enc[$tmp].".jpg";
			$link		="./".$dir3.$prof_x;

			$pict= imagecreatefromjpeg($line_picture);
			$img= imagecreatetruecolor(400,400);

			$img_tmp	= getimagesize($line_picture);
			list($tmp_width, $tmp_height, $type, $attr) = $img_tmp;

			ImageCopyResampled($img, $pict, 0, 0, 0, 0, 400, 400, $tmp_width, $tmp_height);
			imagejpeg($img,$link,100);

			$sql="UPDATE reg SET reg_pic=1 WHERE id='{$tmp_auto}'";
			mysqli_query($mysqli,$sql);

		}
		session_save_path('./session/');
		ini_set('session.gc_maxlifetime', 3*60*60); // 3 hours
		ini_set('session.gc_probability', 1);
		ini_set('session.gc_divisor', 100);
		ini_set('session.cookie_secure', FALSE);
		ini_set('session.use_only_cookies', TRUE);
		session_start();
		$_SESSION["id"]= $tmp_auto;
		$_SESSION["time"]= time();
	}
}
?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
<link rel="stylesheet" href="./css/set_icon.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/first.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/regist.css?_<?=date("YmdHi")?>">

<script src="./js/jquery-3.2.1.min.js"></script>
<script type="text/javascript">

$(function(){ 
	$('#set2').on('click',function(){
		$('#start').submit();
	});

	$('.set_sex1').on('click',function(){
		$(this).addClass('on_1');
		$('.set_sex2').removeClass('on_2');
		$('#sex').val('1');
	});

	$('.set_sex2').on('click',function(){
		$(this).addClass('on_2');
		$('.set_sex1').removeClass('on_1');
		$('#sex').val('2');
	});

	$('#set1').on('click',function () {
		var Err="";
		$('#err').text("");

		if($('#set_name').val() == ""){
			Err="ハンドルがありません<br>";
		}

		if($('#set_y').val() == "" || $('#set_m').val() == "" || $('#set_d').val() == ""){
			Err="生年月日が不正です<br>";
		}

		if($('#sex').val() == ""){
			Err="性別が選択されていません<br>";
		}

		if($('#set_state').val() == ""){
			Err="都道府県が選択されていません<br>";
		}

		if(Err){
			$('#err').html(Err);

		}else{
			$('#form1').submit();
		}
	});
});
</script>
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
<h1 class="h1_irr"><span class="h1_title">LINE連携登録</span></h1>

<?if($line_out =="1"){?>
<div class="main_irr sp_only">
<h1 class="h1_irr"><span class="h1_title">退会されたアカウント</span></h1>
<div class="box_01">
	<div class="box_02">
	退会されているアカウントです。<br>
	</div>
</div>
	<?if($return_ok =="1"){?>
		<div class="send_btn_line" id="line_out">LINE登録で再開</div><br>
	<?}else{?>
		<div class="send_btn_line_ng">LINE登録で再開</div><br>
		<div class="box_01">
			<div class="box_02">
				退会後、24時間経過しないと再開することができません。<br>
			</div>
		</div>
	<? } ?>

<?}elseif($out =="1"){?>
<form action="./line_login.php" method="post">
<div class="box_01"><br>
これでよろしいですか<br><br>
</div>
<table style="margin:2vw auto;">
	<tr>
		<td class="td_a">ハンドル</td>
		<td class="td_b"><?=$name?></td>

	</tr><tr>
		<td class="td_a">誕生日</td>
		<td class="td_b"><?=$yy?>年<?=$mm?>月<?=$dd?>日</td>

	</tr><tr>
		<td class="td_a">性別</td>
		<td class="td_b"><?=$l_sex[$sex]?></td>

	</tr><tr>
		<td class="td_a">地域</td>
		<td class="td_b"><?=$l_state[$state]?></td>
	</tr>
</table>
<div style="text-align:center;">
<button type="submit" class="submit_btn c1" name="done" value="登録">登録</button>　
<button type="submit" class="submit_btn c2" name="send" value="修正">修正</button>
</div>
<input type="hidden" name="name" value="<?=$name?>">
<input type="hidden" name="yy" value="<?=$yy?>">
<input type="hidden" name="mm" value="<?=$mm?>">
<input type="hidden" name="dd" value="<?=$dd?>">
<input type="hidden" name="sex" value="<?=$sex?>">
<input type="hidden" name="state" value="<?=$state?>">
<input type="hidden" name="reg_mail" value="<?=$reg_mail?>">
<input type="hidden" name="reg_code" value="<?=$reg_code?>">
<input type="hidden" name="out" value="2">
<input type="hidden" name="line_id" value="<?=$line_id?>">
<input type="hidden" name="line_picture" value="<?=$line_picture?>">
</form>

<div class="box_alert">
	<span class="title">重要</span>
	性別、生年月日は登録後変更することができません。<br>
	お間違えの無いようご注意下さい。</div>
</div>

<?}elseif($out =="2"){?>
	<div class="box_01">
		登録完了しました。<br>
		ありがとうございます。<br>
	</div>

	<div class="box_03">
		<div id="set2" type="button" value="送信" name="submit" class="send_btn" >今すぐ利用する</div>
	</div>
	<form id="start" action="./index.php"></form>
<?}else{?>

<form id="form1" action="./line_login.php" method="post">
	<input type="hidden" name="reg_mail" value="<?=$line_mail?>">
	<input type="hidden" name="reg_code" value="<?=$reg_code?>">
	<input type="hidden" name="submit_ok" value="1">
	<input type="hidden" name="out" value="1">
	<input type="hidden" name="line_picture" value="<?=$line_picture?>">
	<input type="hidden" name="line_id" value="<?=$line_id?>">

	<div class="box_01">
		<div class="box_02">
			<div class="title">ハンドル<span class="and">　(最大10文字)</span></div>
			<input id="set_name" type="text" value="<?=$line_name?>" name="name" class="send_box" maxlength="10">
		</div>
		<div class="box_02">
			<div class="title">生年月日</div>

			<div>
				<select id="set_y" class="sel" name="yy">
				<option value="00">選択</option>
				<?for($cnt=1960;$cnt<date("Y");$cnt++){?>
				<option value="<?=$cnt?>" <?if($cnt+0 == $yy+0){?>selected<? } ?>><?=$cnt?></option>
				<? } ?>
				</select><span class="sel2">年</span>

				<select id="set_m" class="sel" name="mm">
				<option value="00">選択</option>
				<?for($cnt=1;$cnt<13;$cnt++){?>
				<option value="<?=$cnt?>" <?if($cnt+0 == $mm+0){?>selected<? } ?>><?=$cnt?></option>
				<? } ?>
				</select><span class="sel2">月</span>

				<select id="set_d" class="sel" name="dd">
				<option value="00">選択</option>
				<?for($cnt=1;$cnt<32;$cnt++){?>
				<option value="<?=$cnt?>" <?if($cnt+0 == $dd+0){?>selected<? } ?>><?=$cnt?></option>
				<? } ?>
				</select><span class="sel2">日</span>
			</div>
		</div>

		<div class="box_02">
			<div class="title">性別</div>
			<div>
				<div class="set_sex2">♀女性</div>
				<div class="set_sex1">♂男性</div>
				<input id="sex" type="hidden" value="" name="sex">
			</div>
		</div>

		<div class="box_02">
			<div class="title">都道府県</div>
			<div>
				<select id="set_state" class="sel_state" name="state">
				<option value="">選択</option>
				<option value="1"<? if($state =="1") print(" selected")?>>北海道</option>
				<option value="4"<? if($state =="4") print(" selected")?>>宮城県</option>
				<option value="7"<? if($state =="7") print(" selected")?>>福島県</option>
				<option value="3"<? if($state =="3") print(" selected")?>>岩手県</option>
				<option value="2"<? if($state =="2") print(" selected")?>>青森県</option>
				<option value="5"<? if($state =="5") print(" selected")?>>秋田県</option>
				<option value="6"<? if($state =="6") print(" selected")?>>山形県</option>
				<option value="13"<? if($state =="13") print(" selected")?>>東京都</option>
				<option value="14"<? if($state =="14") print(" selected")?>>神奈川県</option>
				<option value="11"<? if($state =="11") print(" selected")?>>埼玉県</option>
				<option value="12"<? if($state =="12") print(" selected")?>>千葉県</option>
				<option value="8"<? if($state =="8") print(" selected")?>>茨城県</option>
				<option value="9"<? if($state =="9") print(" selected")?>>栃木県</option>
				<option value="10"<? if($state =="10") print(" selected")?>>群馬県</option>
				<option value="17"<? if($state =="17") print(" selected")?>>石川県</option>
				<option value="16"<? if($state =="16") print(" selected")?>>富山県</option>
				<option value="18"<? if($state =="18") print(" selected")?>>福井県</option>
				<option value="15"<? if($state =="15") print(" selected")?>>新潟県</option>
				<option value="20"<? if($state =="20") print(" selected")?>>長野県</option>
				<option value="19"<? if($state =="19") print(" selected")?>>山梨県</option>
				<option value="23"<? if($state =="23") print(" selected")?>>愛知県</option>
				<option value="22"<? if($state =="22") print(" selected")?>>静岡県</option>
				<option value="21"<? if($state =="21") print(" selected")?>>岐阜県</option>
				<option value="24"<? if($state =="24") print(" selected")?>>三重県</option>
				<option value="27"<? if($state =="27") print(" selected")?>>大阪府</option>
				<option value="26"<? if($state =="26") print(" selected")?>>京都府</option>
				<option value="28"<? if($state =="28") print(" selected")?>>兵庫県</option>
				<option value="25"<? if($state =="25") print(" selected")?>>滋賀県</option>
				<option value="29"<? if($state =="29") print(" selected")?>>奈良県</option>
				<option value="30"<? if($state =="30") print(" selected")?>>和歌山県</option>
				<option value="34"<? if($state =="34") print(" selected")?>>広島県</option>
				<option value="33"<? if($state =="33") print(" selected")?>>岡山県</option>
				<option value="35"<? if($state =="35") print(" selected")?>>山口県</option>
				<option value="31"<? if($state =="31") print(" selected")?>>鳥取県</option>
				<option value="32"<? if($state =="32") print(" selected")?>>島根県</option>
				<option value="37"<? if($state =="37") print(" selected")?>>香川県</option>
				<option value="38"<? if($state =="38") print(" selected")?>>愛媛県</option>
				<option value="39"<? if($state =="39") print(" selected")?>>高知県</option>
				<option value="36"<? if($state =="36") print(" selected")?>>徳島県</option>
				<option value="40"<? if($state =="40") print(" selected")?>>福岡県</option>
				<option value="41"<? if($state =="41") print(" selected")?>>佐賀県</option>
				<option value="42"<? if($state =="42") print(" selected")?>>長崎県</option>
				<option value="44"<? if($state =="45") print(" selected")?>>大分県</option>
				<option value="43"<? if($state =="43") print(" selected")?>>熊本県</option>
				<option value="45"<? if($state =="45") print(" selected")?>>宮崎県</option>
				<option value="46"<? if($state =="46") print(" selected")?>>鹿児島県</option>
				<option value="47"<? if($state =="47") print(" selected")?>>沖縄県</option>
				</select>
			</div>
		</div>
		<div id="err"></div>
		<div class="box_03">
			<div id="set1" type="button" value="送信" name="submit" class="send_btn" >送　信</div>
		</div>
	</div>
	<div class="box_alert">
		<span class="title">重要</span>
		性別、生年月日は登録後変更することができません。<br>
		お間違えの無いようご注意下さい。</div>
	</div>

<? } ?>
<?include_once("./x_foot.php")?>
</body>
</html>
