<?
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/POP3.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/OAuth.php';
require 'PHPMailer/language/phpmailer.lang-ja.php';

mb_language("Japanese");
mb_internal_encoding("UTF-8");
$date=date("Y-m-d H:i:s");


include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/no_session.php");
include_once("./library/lib_regist.php");
if($_SESSION){
	$_SESSION = array();
	session_destroy(); 
}

$sql="SELECT * FROM me_encode";
$result = mysqli_query($mysqli,$sql);

while($row = mysqli_fetch_assoc($result)){
	$s_key[$row["gp"]][$row["value"]]=$row["key"];
}

$target		=$_REQUEST["target"];
$send		=$_POST["send"];
$reg_mail	=$_POST["reg_mail"];
$reg_pass	=$_POST["reg_pass"];

$submit		=$_POST["submit"];
$submit_ok	=$_POST["submit_ok"];
$done		=$_POST["done"];

$name		=$_POST["name"];
$yy			=$_POST["yy"];
$mm			=$_POST["mm"];
$dd			=$_POST["dd"];
$sex		=$_POST["sex"];
$state		=$_POST["state"];
$reg_code	=$_POST["reg_code"];

if(!$yy) $yy=2000;

if($done){
	$sql ="SELECT * FROM reg";
	$sql.=" WHERE reg_mail='{$reg_mail}'";
	$sql.=" LIMIT 1";

	$result = mysqli_query($mysqli,$sql);
	$ck = mysqli_fetch_assoc($result);

	if(count($ck)>0){
		$out=7;

	}else{
		$out=6;
		$birth=$yy."-".$mm."-".$dd;
		$sql="INSERT INTO `reg`(`reg_name`,`reg_mail`,`reg_pass`,`reg_style`,`reg_state`,`reg_birth`,`reg_date`,`reg_sex`,`reg_rank`,`reg_code`)";
		$sql.=" VALUES('{$name}','{$reg_mail}','{$reg_pass}','1','{$state}','{$birth}','{$date}','{$sex}',11,'{$reg_code}')";
		mysqli_query($mysqli,$sql);

		$tmp_auto=mysqli_insert_id($mysqli)+0;
		$sql_up	 ="INSERT INTO me_prof(`prof_id`,`name`,`mail`)";
		$sql_up	.="VALUES('{$tmp_auto}','{$name}','{$reg_mail}')";
		mysqli_query ($mysqli,$sql_up);
		mb_language("Japanese");
		mb_internal_encoding("UTF-8");

		$tmp_code=$tmp_auto.$reg_pass;
		for($t=0;$t<strlen($tmp_code);$t++){
			$tmp_key=substr($tmp_code,$t,1);
			$login_code.=$s_key[$t][$tmp_key];
		}

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

		$msg=file_get_contents("./mail/mail_2.txt");
		$msg=str_replace("[name]",$name,$msg);
		$msg=str_replace("[reg_id]",$tmp_auto,$msg);
		$msg=str_replace("[login]",$login_code,$msg);

		$mailer = new PHPMailer();
		$mailer->IsSMTP();

		$mailer->Host		= $host;
		$mailer->CharSet	= 'utf-8';
		$mailer->SMTPAuth	= TRUE;
		$mailer->Username	= $mail_from;
		$mailer->Password	= $mail_pass;
		$mailer->SMTPSecure = 'tls';
		$mailer->Port		= 587;
//		$mailer->SMTPDebug = 2;

		$mailer->From     = $mail_from;
		$mailer->FromName = mb_convert_encoding("写真名刺作成サイト★OnlyMe","UTF-8","AUTO");
		$mailer->Subject  = mb_convert_encoding('会員登録完了',"UTF-8","AUTO");
		$mailer->Body     = mb_convert_encoding($msg,"UTF-8","AUTO");
		$mailer->AddAddress($reg_mail);
		if($mailer->Send()){
		}else{
			$sql="INSERT INTO mail_error_log (`date`,`log_no`,`to_mail`)";
			$sql.=" VALUES('{$date}','regist2.php','{$reg_mail}');";
			mysqli_query($mysqli,$sql);
		}
	}

}elseif($submit_ok){
	$out=5;

}elseif($send){
	$out=4;

}elseif($target){
	$out=3;
	$l_time=substr($target,2,4).substr($target,0,2).substr($target,8,2).substr($target,10,2).substr($target,12,2).substr($target,6,2);
	$reg_pass=substr($target,14);

	if($l_time>date("YmdHis",time-1800)){
		$sql="SELECT * FROM reg_try WHERE date_code='{$target}'";
		$sql.=" ORDER BY id DESC";
		$sql.=" LIMIT 1";

		$res1=	mysqli_query($mysqli,$sql);
		$res2 = mysqli_fetch_assoc($res1);

		$sql="SELECT * FROM reg WHERE reg_mail='{$res2["mail"]}'";

		$dn1	=mysqli_query($mysqli,$sql);
		$dn2	=mysqli_fetch_assoc($dn1);
		if(count($dn2)>0){
			header('Location: https://onlyme.fun');
			exit;
		}
		$t_date=date("Y-m-d H:i:s",time()-2000);
		if($t_date>$res2["date"]){
			$out=1;//□タイムアウト

		}elseif($res2){//□正常
			$out=3;
			$reg_mail=$res2["mail"];
			$reg_code=$res2["reg_code"];

		}else{//□パラメータがおかしい
			$out=2;//□パラメータ不足
		}

	}else{
		$out=1;//□タイムアウト
	}

}else{
	$out=2;//□パラメータ不足
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
	$('#send3').on('click',function(){
		if ($('#reg_pass').val() == '<?=$reg_pass?>') {
			$('#forms').submit();

		}else{
			$('#err').text('パスワードが違います');
			return false;
		}
	});

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
<h1 class="h1_irr"><span class="h1_title">新規登録(無料)</span></h1>

<?if($out =="1"){?>
<div class="box_01"><br>
	仮登録の有効期限が切れてます。<br>
	もう一度ご登録くださいませ<br>
<br>
</div>
<br>
<a href="./regist.php" class="regist_in">新規登録</a><br>

<?}elseif($out =="2"){?>
<div class="box_01">
<div class="box_02">
	エラーが発生しました<br>
	送られて来たメールよりログインしてください。<br>
</div>
</div>

<?}elseif($out =="3"){?>
<form id="forms" action="./regist2.php" method="post">
<input type="hidden" name="reg_mail" value="<?=$reg_mail?>">
<input type="hidden" name="target" value="<?=$target?>">
<input type="hidden" name="send" value="1">
<input type="hidden" name="reg_code" value="<?=$reg_code?>">
<div class="box_01">
	<div class="box_02">
	ご登録ありがとうございます。<br>
	登録時のパスワードを入力して下さい<br>
	</div>
	<div class="box_02">
		<span class="title">パスワード</span><br>
		<input id="reg_pass" type="text" value="" name="reg_pass" class="send_box"><br>
		<span class="and">※半角英数字4～10文字</span><br>
	</div>
<div id="err"></div>
	<div class="box_03">
		<button id="send3" type="button" value="確認" name="send_btn" class="send_btn" >確　認</button>
	</div>
</div>
</form>

<?}elseif($out =="4"){?>

<form id="form1" action="./regist2.php" method="post">
<input type="hidden" name="reg_mail" value="<?=$reg_mail?>">
<input type="hidden" name="reg_pass" value="<?=$reg_pass?>">
<input type="hidden" name="target" value="<?=$target?>">
<input type="hidden" name="reg_code" value="<?=$reg_code?>">
<input type="hidden" name="submit_ok" value="1">

	<div class="box_01">
		パスワードが承認されました。<br>
		下記に必要事項を登録ください。<br>
	</div>

	<div class="box_01">
		<div class="box_02">
			<div class="title">ハンドル<span class="and">　(最大10文字)</span></div>
			<input id="set_name" type="text" value="<?=$name?>" name="name" class="send_box" maxlength="10">
		</div>
		<div class="box_02">
			<div class="title"">生年月日</div>

			<div>
				<select id="set_y" class="sel" name="yy">
				<option value="00">選択</option>
				<?for($cnt=1960;$cnt<2017;$cnt++){?>
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
</form>
<?}elseif($out =="5"){?>

<form action="./regist2.php" method="post">
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
<input type="hidden" name="reg_pass" value="<?=$reg_pass?>">
<input type="hidden" name="reg_code" value="<?=$reg_code?>">
</form>

<div class="box_alert">
	<span class="title">重要</span>
	性別、生年月日は登録後変更することができません。<br>
	お間違えの無いようご注意下さい。</div>
</div>


<?}elseif($out =="6"){?>
	<div class="box_01">
		登録完了しました。<br>
		ありがとうございます。<br>
	</div>

	<div class="box_03">
		<div id="set2" type="button" value="送信" name="submit" class="send_btn" >ログイン</div>
	</div>

	<form id="start" action="./index.php">
		<input type="hidden" name="log_in" value="<?=$reg_mail?>">
		<input type="hidden" name="log_pass" value="<?=$reg_pass?>">
	</form>

<?}elseif($out =="7"){?>
	<div class="box_01">
		<br>ご利用のメールアドレスは、既にご登録済です。<br><br>
	</div>

<?}else{?>
	<div class="box_01">
		エラー
	</div>
<?}?>


<div class="err"></div>
</div>

<?include_once("./x_foot.php")?>
</body>
</html>
