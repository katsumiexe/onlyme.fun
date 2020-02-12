<?include_once("./x_irr.php")?>
<div class="main">
	<H1 class="h1"><span class="h1_title">写真名刺作成サイト★OnlyMe</span></h1>
	<div class="top_img">
		<img src="./img/top.png" style="width:100%;" alt="onlyme_top">
		<div class="top_login">
			<form id="user_login" action="./index.php" method="post">
				<input type="text" name="log_in" placeholder="ID or ADDRESS" class="top_input"><br>
				<input type="password" name="log_pass" placeholder="PASSWORD" class="top_input"><br>
				<span class="btn_login">LOGIN</span>
			</form>
		</div>
		<a href="https://twitter.com/onlyme_staff" class="link_twitter"></a>
		<a href="https://instagram.com/onlyme_staff" class="link_insta"></a>
		<a href="./outpost.php" class="link_mail"></a>
	</div>
	<div class="top_msg">
スマホで作成<br>
コンビニで印刷<br>
手軽で簡単な写真名刺制作サイトです<br>

		<span class="err_msg"><?=$msg?></span>
	</div>
	<div class="box0">
		<div class="box1">
			<div class="box2">パソコン不要</div>
			<div class="box3">
				デザイン、写真設定、データセットまで全てスマホで操作。<br>
				パソコンも専門ソフトも知識もいりません。
			</div>
		</div>

		<div class="box1">
			<div class="box2">住所登録不要</div>
			<div class="box3">
				デザインした名刺はファミリーマート・ローソン設置のコピー機で印刷できます。<bR>
				住所登録も、届くまで待つこともありません。
			</div>
		</div>

		<div class="box1">
			<div class="box2">登録料金不要</div>
			<div class="box3">
				登録から作成まですべて無料。かかる料金はコンビニの印刷代のみ。3枚80円から印刷可能です。<br>
			</div>
		</div>
	</div>

<br><br>
<br><br>
<br><br>
</div>
<?include_once("./x_foot.php")?>
