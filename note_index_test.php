<?php
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/session.php");
$nowpage=1;
$ex=8;
$d=0;

$base_d=date("Y-m-d 23:59:00",time()-518400);
$sql="SELECT p_api_code FROM me_plist_main";
$sql.=" WHERE p_user_id='{$user["id"]}'";
$sql.=" AND p_del=0";
$sql.=" AND p_date>'{$base_d}'";
$sql.=" LIMIT 1";
$result = mysqli_query($mysqli,$sql);
if($dat = mysqli_fetch_assoc($result)){	
	$code=$dat["p_api_code"];
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
<link rel="stylesheet" href="./css/set_icon.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/first.css?_<?=date("YmdHi")?>">
<link rel="stylesheet" href="./css/note.css?_<?=date("YmdHi")?>">

<script src="./js/jquery-3.2.1.min.js"></script>
<script src="./js/first.js"></script>
<script src="./js/note.js"></script>
<script>
</script>
</head>
<body class="body">
<?if(!$_SESSION["id"]){?>
<?include_once("./x_irr.php")?>
<?}else{?>
<?include_once("./x_head.php")?>
<?}?>
<div class="main">
<h2 class="h2">印刷可能なコンビニ</h2>
<div class="exp_box1">
<img src="./img/print_logo.jpg" class="note_img"><br>
<span class="ok1">ファミリーマート</span>と<span class="ok1">ローソン</span>のマルチコピー機で印刷可能です。<br>
<span class="ng1">セイコーマートのマルチコピー機、セブンイレブンのネットプリントはご利用いただけません。</span>ご注意ください。<br>
※一部対応していない店舗もございます。詳細は各店舗にご確認下さい。<br>

</div>

<h2 class="h2">プリントリスト作成</h2>
<div class="exp_box1">
<span class="ok2"><span class="icon_img"></span>Album</span>⇒<span class="ok2">「プリント」</span>を選択してください。<br>
プリントしたい名刺データの右上の『<span class="icon_img"></span>』をタップしますと、プリントリストに追加できます。<br>
プリントリストには最大10枚までの名刺データを追加できます。<br>
プリントリストは一つしか作成できません。新たに作成する場合は、既存のプリントリストを削除する必要があります。<br>
プリントリストの使用期限は作成日含め、7日間です。<br>
</div>
<h2 class="h2">プリント手順</h2>

<div class="exp_box1">
ファミリーマート・ローソンのマルチコピー機での操作方法です。<br>
</div>

<div class="exp_box1_1">
	<div class="exp_box1_1_1">
		<img src="./img/tuto/print_01.png" class="exp_box_img">
	</div>
	<div class="exp_box1_1_2">
		・【プリントサービス】を選択。
	</div>
</div>

<div class="exp_box1_1">
	<div class="exp_box1_1_1">
<img src="./img/tuto/print_02.png" class="exp_box_img">

	</div>
	<div class="exp_box1_1_2">
		・【ネットワークプリント】を選択。
	</div>
</div>

<div class="exp_box1_1">
	<div class="exp_box1_1_1">
<img src="./img/tuto/print_03.png" class="exp_box_img">
	</div>
	<div class="exp_box1_1_2">
		・「ユーザー番号」を入力。<br>
<?if($code){?>
		※ユーザー番号<br><span class="exp_code">[<?=$code?>]</span>
<?}else{?>		
		※ユーザー番号は<a href="./mydata.php?tag=print"><span class="exp_code">プリントリスト作成</span></a>のページに表示されます。
<?}?>

	</div>
</div>

<div class="exp_box1_1">
	<div class="exp_box1_1_1">
<img src="./img/tuto/print_04.png" class="exp_box_img">

	</div>
	<div class="exp_box1_1_2">
		・「L版写真プリント」を選択。
	</div>
</div>

<div class="exp_box1_1">
	<div class="exp_box1_1_1">
<img src="./img/tuto/print_05.png" class="exp_box_img">

	</div>
	<div class="exp_box1_1_2">
		・「2L」を選択。
	</div>
</div>

<div class="exp_box1_1">
	<div class="exp_box1_1_1">
<img src="./img/tuto/print_06.png" class="exp_box_img">

	</div>
	<div class="exp_box1_1_2">
		・印刷したい名刺デザインと枚数を選択し、表示された金額をコインベンダーに投入。
	</div>
</div>

<div class="exp_box1_1">
	<div class="exp_box1_1_1">
<img src="./img/tuto/print_07.png" class="exp_box_img">

	</div>
	<div class="exp_box1_1_2">
		・詳細設定は変更せず、「プリント開始」を押してください。<br>
		※1枚の印刷時間は約1分30秒です。
	</div>
</div>
<br>
</div>

<?include_once("./x_foot.php")?>
</body>
</html>