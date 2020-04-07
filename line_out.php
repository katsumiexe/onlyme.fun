<?
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/no_session.php");
include_once("./library/lib_regist.php");


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
	var User_id='<?=$user_id?>';
	var RegLine='<?=$reg_line?>';

	$('.send_btn_line').click(function(){
		$.post({
			url:'post_line_remove.php',
			data:{'user_id':User_id,'reg_line':RegLine},
			dataType: 'json',

		}).done(function(data){				

		})
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
<h1 class="h1_irr"><span class="h1_title">退会されたアカウント</span></h1>

<div class="box_01">
<div class="box_02">
こちらのアカウントは退会されているため、ログインできません。<br>
再開するにはご本人確認が必要です。
</div>
</div>


<a href="regist_again.php" class="send_btn_mail" id="mail_out">メールアドレスで確認</a><br>
<div class="send_btn_line" id="line_out">LINE登録で確認</div><br>
<div class="box_01">
<div class="box_02">
退会後、24時間経過しないと再開することができません。<br>
</div>
</div>

<div class="ft_box">
<a href="policy.php" class="ft"><span class="ft_ar icon_img"></span><span class="ft_txt">プライバシーポリシー</span></a>
<a href="kiyaku.php" class="ft"><span class="ft_ar icon_img"></span><span class="ft_txt">利用規約</span></a>
<a href="outpost.php" class="ft"><span class="ft_ar icon_img"></span><span class="ft_txt">お問い合わせ・ご意見</span></a>
</div>
</div>
<?include_once("./x_foot.php")?>
</body>
</html>


