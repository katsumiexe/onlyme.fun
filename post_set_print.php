<?
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/session.php");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}

$base_d=date("Y-m-d 00:00:00",time()-604800);
$user_id	=$_POST["user_id"];
$print_ck	=$_POST["print_ck"];

/*-------------------------------------------------------------*/
$ck_css[0]=" ck_mes c_wt";
$ck_css[1]=" ck_mes c_ok";
$ck_css[2]=" ck_mes c_ng";

$ck_msg[0]="<span class=\"ck_mes c_wt\"><span class=\"ck_icon\"></span><span class=\"ck_text\">転送中</span></span>";
$ck_msg[1]="<span class=\"ck_mes c_ok\"><span class=\"ck_icon\"></span><span class=\"ck_text\">印刷可能</span></span>";
$ck_msg[2]="<span class=\"ck_mes c_ng\"><span class=\"ck_icon\"></span><span class=\"ck_text\">転送失敗</span></span>";


$met	=file_get_contents("https://api.networkprint.jp/rest/webapi/v2/maintenanceInfo");
$met2	=json_decode($met,true);
if($met2["status"] == "emergency"){
	$ch_list["mente"]=1;

}elseif($met2["status"] == "scheduled"){
	$ch_list["mente"]=2;

}else{
	if($met2["maintenanceTime"]["from"] >$now && $met2["maintenanceTime"]["to"] > $now){
		$ch_list["mente"]=3;
	}
}

/*-------------------------------------------------------------*/


$cnt=0;
$now=date("Y-m-d H:i:s");
$cont_font	="./font/RobotoCondensed-Regular.ttf";

$url = "https://api.networkprint.jp/rest/webapi/v2";
$dat1["app_key"]	= "85B35DD2-7B07-4560-A04B-C564425DDFE8";
$dat1["api_ver"]	= "2.7";
$dat1["M"]		= "loginForGuest2";

$content = http_build_query($dat1);
$dat2 = array(
	'http' => array(
		'method' => 'POST',
		'content'=> $content
	)
);

if($j_token = file_get_contents($url, false, stream_context_create($dat2))){
	$n_token =json_decode($j_token);

	foreach($n_token as $aa1 => $aa2){
		$dat_token[$aa1]=$aa2;
	}

	krsort($print_ck);

	if($dat_token["result"] ==0){
		$sql ="INSERT INTO `me_plist_main`(p_date,p_user_id,p_api_code,api_token)";
		$sql .="VALUES('{$now}','{$user["id"]}','{$dat_token["userCode"]}','{$dat_token["authToken"]}')";
		mysqli_query($mysqli,$sql);

		$tmp_auto=mysqli_insert_id($mysqli);	
		$ch_list["code"]	=$dat_token["userCode"];
		$ch_list["limit"]	=date("m月d日 23:59",time()+518400);
		$ch_list["token"]	=$dat_token["authToken"];


		foreach($print_ck as $a1=>$a2){
			if($a2 == 1){
				$sql0 ="SELECT * FROM `me_making`";
				$sql0.=" WHERE `making_id`='{$a1}'";
				$sql0.=" AND `del`=0";
				$sql0.=" LIMIT 1";
				$res = mysqli_query($mysqli,$sql0);
	
				if($dat_i = mysqli_fetch_assoc($res)){
					$main_img=$dir.$dat_i["img"];

					$tmp2= imagecreatefromjpeg($main_img);

					$img_x=imagesx($tmp2);
					$img_y=imagesy($tmp2);

					$b			=2;
					$base_x		=275*$b;
					$base_y		=455*$b;
					$print_x0	=890*$b;
					$print_y0	=635*$b;

					$tmp3	=imagecreatetruecolor($print_x0,$print_y0);
					$bk		=ImageColorAllocate($tmp3,0,0,0);
					$wh		=ImageColorAllocate($tmp3,255,255,255);
					$rd		=ImageColorAllocate($tmp3,0,0,255);

					imagefill($tmp3, 0, 0, $wh);
					$base_x	-= 10;
					$base_y	-= 15;

					//■縦軸--------------
					for($n=0;$n<4;$n++){	
						imageline($tmp3, $base_x*$n+50+$n, 50, $base_x*$n+90+$n, 50, $bk);
						imageline($tmp3, $base_x*$n+70+$n, 50, $base_x*$n+70+$n, 70, $bk);

						imageline($tmp3, $base_x*$n+50+$n, $base_y+140, $base_x*$n+90+$n, $base_y+140, $bk);
						imageline($tmp3, $base_x*$n+70+$n, $base_y+120,  $base_x*$n+70+$n, $base_y+140, $bk);
					}

					//■横軸左--------------
					imageline($tmp3, 30, 89, 50, 89, $bk);
					imageline($tmp3, 30, 70, 30, 110, $bk);

					imageline($tmp3, 30, $base_y+90, 50, $base_y+90, $bk);
					imageline($tmp3, 30, $base_y+70, 30, $base_y+110, $bk);

					imageline($tmp3, $base_x*3+60+30, 89, $base_x*3+60+50, 89, $bk);
					imageline($tmp3, $base_x*3+60+50, 70, $base_x*3+60+50, 110, $bk);

					imageline($tmp3, $base_x*3+60+30, $base_y+90, $base_x*3+60+50, $base_y+90, $bk);
					imageline($tmp3, $base_x*3+60+50, $base_y+70, $base_x*3+60+50, $base_y+110, $bk);

					//■main--------------
					ImageCopyResampled($tmp3, $tmp2, ($base_x+1)*0+71, 90, 0, 0, $base_x, $base_y, $base_x+10, $base_y+15);
					ImageCopyResampled($tmp3, $tmp2, ($base_x+1)*1+71, 90, 0, 0, $base_x, $base_y, $base_x+10, $base_y+15);
					ImageCopyResampled($tmp3, $tmp2, ($base_x+1)*2+71, 90, 0, 0, $base_x, $base_y, $base_x+10, $base_y+15);

					imagettftext($tmp3, 30, 0, 200, 1150, $rd, $cont_font, $now);
					imagejpeg($tmp3,$dir."/print".$cnt.".jpg");
				}

				sleep(1);
				$api_url = "https://api.networkprint.jp/rest/webapi/v2";
				$dat3["token"]		= $dat_token["authToken"];
				$dat3["location"]	= "https://onlyme.fun/{$dir}print{$cnt}.jpg";
				$dat3["filename"]	= date("YmdHi").".jpg";
				$dat3["M"]			= "registFile";
				$dat3["name"]		= $user["id"]."-".$cnt;

				$content = http_build_query($dat3);
				$dat4 = array(
					'http' => array(
						'method' => 'POST',
						'content'=> $content
					)
				);

				if($x_token = file_get_contents($api_url, false, stream_context_create($dat4))){
					$y_token =json_decode($x_token);
					foreach($y_token as $b1 => $b2){
						$z_token[$b1]=$b2;
					}

					$apps.="('{$tmp_auto}','{$a1}','{$z_token["fileID"]}'),";

					$ch_list["list"]	.="<div class=\"index_frame\">";
					$ch_list["list"]	.="<img src=\"{$main_img}\" class=\"index_img\">";

					$ch_list["list"]	.="<span>{$z_token["fileID"]}</span>";
					$ch_list["list"]	.="</div>";
					
				}else{//■プリントデータがPOSTできなかった	
					$sql ="INSERT INTO `me_print_error`(e_date,user_id,code,me_error)";
					$sql .="VALUES('{$now}','{$user["id"]}','{$dat_token["result"]}','2')";
					mysqli_query($mysqli,$sql);
					$ch_list["err"]	=$z_token["result"];
				}
					$cnt++;
			}
		}
	}else{//■アクセストークンが作成できなかった
		$sql ="INSERT INTO `me_print_error`(e_date,user_id,code,me_error)";
		$sql .="VALUES('{$now}','{$user["id"]}','{$dat_token["result"]}','1')";
		mysqli_query($mysqli,$sql);
		$ch_list["err"]	=$dat_token["result"];
	}

	if($ch_list["err"]){

		$dat_e["code"]	= $ch_list["err"];
		$dat_e["M"]		= "getMessage";

		$content = http_build_query($dat_e);
		$dat_e2 = array(
			'http' => array(
				'method' => 'POST',
				'content'=> $content
			)
		);

		if($e_token = file_get_contents($url, false, stream_context_create($dat_e2))){
			$err_check =json_decode($e_token);
			foreach($err_check as $ec1 => $ec2){
				$dat_err[$ec1]=$ec2;
			}
		}
		if(!$dat_err["message"]){
			$dat_err["message"]="予期せぬエラーです";
		}

	}else{
		$apps=substr($apps,0,-1);
		$sql ="INSERT INTO `me_plist_sub`(main_id,p_making_id,p_file_id)";
		$sql .=" VALUES ";
		$sql .=$apps;
		mysqli_query($mysqli,$sql);

		$url = "https://api.networkprint.jp/rest/webapi/v2";

		$dat_e["token"]	= $dat_token["authToken"];
		$dat_e["M"]		= "getFileList";

		$content = http_build_query($dat_e);
		$dat_e2 = array(
			'http' => array(
				'method' => 'POST',
				'content'=> $content
			)
		);

		if($e_token = file_get_contents($url, false, stream_context_create($dat_e2))){
			$err_check =json_decode($e_token,true);

			for($n=0;$n<$err_check["totalFiles"];$n++){
				$tmp="<span>{$err_check["fileList"][$n]["fileID"]}</span>";
				$ch_list["list"]=str_replace($tmp,$ck_msg[$err_check["fileList"][$n]["status"]],$ch_list["list"]);
			}
		}
	}
}
echo json_encode($ch_list);
exit;
?>
