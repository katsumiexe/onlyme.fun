<?php
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/session.php");
$nowpage=1;
$ex=8;
$d=0;
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
<link rel="stylesheet" href="./css/exp.css?_<?=date("YmdHi")?>">

<script src="./js/jquery-3.2.1.min.js"></script>
<style>
.exp_table{
	width:92vw;
	margin:1vw auto;
	border:1vw solid #f0c0d0;
	margin-bottom:3vw;
}

.exp_title{
	height:5vw;
	line-height:5vw;
	border:0.2vw solid #303030;
	font-size:3.8vw;
	text-align:center;
	vertical-align:middle;
	background:#f17766;
	color:#ffffff;
	font-weight:600;
}

.exp_cnt,.exp_pts{
	width:18vw;
	padding:1vw;
}

.exp_act2{
	border:0.2vw solid #303030;
	text-align:left;
	background:#fafafa;
	height:6vw;
	line-height:6vw;
	font-size:3.8vw;
	padding:1vw;
}

.exp_cnt2,.exp_pts2{
	border:0.2vw solid #303030;
	text-align:right;
	background:#fafafa;
	font-size:3.8vw;
	padding:1vw;
}

.exp_box1{
	padding:1vw;
	background:#fff0f5;
	width:90vw;
	margin:2vw auto;
	border:1vw solid #f0c0d0;
	border-radius:2vw;
	text-align:left;
}
.exp_box2{
	padding:2vw;
	background:#e0e0e0;
	width:80vw;
	margin:1vw auto;
	text-align:left;
}


.exp_msg{
	border:0.2vw solid #303030;
	padding:0.5vw;
	color:#303030;
	background:#fafafa;
	display:inline-block;
	width:80vw;
	text-align:left;
}

.exp_lv1{
	border:0.2vw solid #303030;
	height:16vw;
	width:24vw;
	text-align:center;
	vertical-align:middle;
	color:#ffffff;
	background:#0000d0;
	font-weight:800;
	font-size:5vw;
}

.exp_com{
	border:0.2vw solid #303030;
	height:12vw;
	line-height:6vw;
	color:#606060;
	background:#fafafa;
	font-size:3vw;
	padding:1vw;
	text-align:left;
}
</style>

</head>
<body class="body">
<?if(!$_SESSION["id"]){?>
<?include_once("./x_irr.php")?>
<div class="main2">
<?}else{?>
<?include_once("./x_head.php")?>
<div class="main">
<?}?>

<h1 class="h1"><span class="h1_title">ヘルプ</span></h1>
<h2 class="h2">プロフィール画像の登録</h2>
<div class="exp_box1">
</div>

はじめに
　登録について
　退会・再開
　利用規約
　プライバシーポリシー

使い方
　見る
　　
　アルバム
	お知らせの確認
	評価を見る
	応援を見る
	データ削除
	再印刷
　　フォロー者リスト
　　フォロワー者リスト

　作成
	作り方	

　印刷
	作成した名刺をコンビニで印刷する
	
　拡散
	作成した名刺をtwitterにアップする

　Config
	プロフィール画像の登録
	基本情報の変更
	名刺内容の変更
	退会

１画像登録まで
デザインから、元となるフレームを選びましょう
スマホから写真をアップしてください。
テンプレートの変更があれば、ここで変更することができます。
※使用画像・画像回転・QRコードはここでしか設定が出来ません。

２画像修正
赤い実線が名刺の淵となります。
ここから外は印刷はされません。
画像を直接スワイプし、位置を動かすことができます。
１
画像に様々な効果をつけたり、拡大・縮小することができます。。

２
テンプレートを修正することができます。

３変更完了したら「次へ」


「Onlyme」では他のユーザーが作った名刺を見ることができます。

評価する
「カワイイ」「イケメン」「オモシロ」「セクシー」の4タイプあります。
ボタンをタップすることで、どれか一つに評価を付けることができます。
複数を選択することは出来ません。

応援する
名刺の作成者にメッセージを送ることができます。
こちらも一つだけです。
二つ目を送信しますと、一つ目に上書きされます。

通報する
使用写真が不適切、サイト規約に反すると思ったものがありましたらご連絡下さい。
スタッフが確認の上、対応させていただきます。
通報は匿名で行われます。スタッフ、およびお相手には通知されません。

フォローする
各ユーザーのプロフィールページより、フォローすることができます。


アルバムの使い方

お知らせ
	他ユーザーから応援コメントが入ったり、他ユーザーからフォローされたりしたときにお知らせが入ります。
	
アルバム
	自分が作った名刺を確認することができます。
	評価を確認したり応援コメントを見たりすることができます。
	データの削除・再印刷などもここより行えます。

フォロー者リスト
	あなたがフォローしているユーザーの一覧です。
	相互フォローになっている相手は、色がついてます。

フォロワー者リスト
	あなたがフォローされているユーザーの一覧です。
	相互フォローになっている相手は、色がついてます。

名刺を作りたいけど、作り方がわからないし、そもそもパソコン持っていない。
家に送られのが嫌。親はコスプレを良く思っていないので、見つかったら怒られるかも。
安くするためにロットを増やしているけど、少量でいいからたくさん種類を作りたい。

使わない：12%
印刷会社：14%
友達（カメラマン）:21%
自作：48%
その他：5%

<?include_once("./x_foot.php")?>
</body>
</html>