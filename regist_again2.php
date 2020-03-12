<?
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/no_session.php");

$pcode		=$_REQUEST["code"];
$nowpage=4;

$date		=date("Y-m-d H:i:s");
$date_lim	=date("Y-m-d H:i:s",time()-1800);
$date_code	=date(mYsdHi).$me_pass;

$sql	 ="SELECT * FROM me_config_chg";
$sql	.=" LEFT JOIN `reg` ON user_id=`reg`.`id`";
$sql	.=" WHERE `code`='{$pcode}'";
$sql	.=" AND `date`>'{$date_lim}'";
$sql	.=" AND `reg`.`reg_rank`='2'";
$sql	.=" LIMIT 1";
$re=mysqli_query ($mysqli,$sql);
if($dat = mysqli_fetch_assoc($re)){
	$sql  ="UPDATE reg SET";
	$sql .=" reg_rank=11";
	$sql .=" WHERE id='{$dat["user_id"]}'";
	$sql .=" AND reg_rank='2'";
	mysqli_query ($mysqli,$sql);

	$ck=1;

	$sql	 ="SELECT reg_pass FROM reg";
	$sql	.=" WHERE id='{$dat["user_id"]}'";
	$sql	.=" LIMIT 1";

	$re2=mysqli_query ($mysqli,$sql);
	$dat2 = mysqli_fetch_assoc($re2);
	$pass=$dat2["reg_pass"];

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
<script>
$(function(){ 
	$('#set2').on('click',function(){
		$('#start').submit();
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
<h1 class="h1"><span class="h1_title">再登録</span></h1>
<?if($ck == 1){?>
	<div class="box_01">
		<span style="font-weight:600;width:100%;text-align:center;">再登録受付完了</span><br>
		<span style="text-align:left;">
			再登録されました。<br>
			下記よりログインいただけます。<br>
		</span>
	</div>
	<button id="set2" type="button" value="送信" name="send" class="send_btn" >ログイン</button>

<?}else{?>
	<div class="box_01">
		<span style="font-weight:600;width:100%;text-align:center;">エラーが発生しました</span><br>
		<div class="box_02">
			処理時にエラーが発生しました。<br>
			以下の可能性が考えられます。<br>
			・すでに再開処理がされている<br>
			・手続きから30分以上が経過している<br>
			・メールアドレスが間違っている<br>
			・再開処理ができないアカウント<br>
		</div>
	</div>
<?}?>
<div class="ft_box">
<a href="policy.php" class="ft"><span class="ft_ar icon_img"></span><span class="ft_txt">プライバシーポリシー</span></a>
<a href="kiyaku.php" class="ft"><span class="ft_ar icon_img"></span><span class="ft_txt">利用規約</span></a>
<a href="outpost.php" class="ft"><span class="ft_ar icon_img"></span><span class="ft_txt">お問い合わせ・ご意見</span></a>
</div>
</div>
<form id="start" action="./index.php">
<input type="hidden" name="log_in" value="<?=$dat["user_id"]?>">
<input type="hidden" name="log_pass" value="<?=$pass?>">
</form>
<?include_once("./x_foot.php")?>
</body>
</html>
