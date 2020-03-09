<?
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/no_session.php");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}

$base_d=date("Y-m-d 23:59:00",time()-518400);

$sql ="SELECT print_id FROM `me_print_log`";
$sql.=" WHERE `date`>'{$base_d}'";

if($res0 = mysqli_query($mysqli,$sql)){
	while($row0 = mysqli_fetch_assoc($res0)){
		$yet_date[$row0["print_id"]]=1;
	}
}

$sql ="SELECT * FROM `me_plist_main`";
$sql.=" WHERE `p_date`>'{$base_d}'";
if($res1 = mysqli_query($mysqli,$sql)){
	while($row1 = mysqli_fetch_assoc($res1)){

		$sql ="SELECT * FROM `me_plist_sub`";
		$sql.=" LEFT JOIN me_making ON p_making_id=making_id";
		$sql.=" WHERE `main_id`='{$row1["p_main_id"]}'";

		if($res2 = mysqli_query($mysqli,$sql)){
			while($row2 = mysqli_fetch_assoc($res2)){
				$print_id[$row2["p_file_id"]]=$row2["p_making_id"];
				$print_tmpl[$row2["p_file_id"]]=$row2["use_tmpl"];
				$print_user[$row2["p_file_id"]]=$row2["user_id"];
			}
		}

		$url = "https://api.networkprint.jp/rest/webapi/v2";

		$dat_e["token"]	= $row1["api_token"];
		$dat_e["M"]		= "getFileList";

		$content = http_build_query($dat_e);
		$dat_e2 = array(
			'http' => array(
				'method' => 'POST',
				'content'=> $content
			)
		);

		if($e_token = file_get_contents($url, false, stream_context_create($dat_e2))){
			$p_count =json_decode($e_token,true);

			for($n=0;$n<$p_count["totalFiles"];$n++){
/*
				print($p_count["fileList"][$n]["fileID"]."<br>\n");
				print($p_count["fileList"][$n]["printedCount"]."<br>\n");
				print($print_id[$p_count["fileList"][$n]["fileID"]]."<br>\n");
				print($print_tmpl[$p_count["fileList"][$n]["fileID"]]."<br>\n");
				print($print_user[$p_count["fileList"][$n]["fileID"]]."<br>\n<hr>");
*/
				if($p_count["fileList"][$n]["printedCount"]>0){

					if($yet_date[$p_count["fileList"][$n]["fileID"]]== 1){
						$sql="UPDATE me_print_log SET";
						$sql.=" `date`='{$date}',";
						$sql.=" `user_id`='{$print_user[$p_count["fileList"][$n]["fileID"]]}',";
						$sql.=" `making_id`='{$print_id	[$p_count["fileList"][$n]["fileID"]]}',";
						$sql.=" `tmpl_id`='{$print_tmpl[$p_count["fileList"][$n]["fileID"]]}',";
						$sql.=" `print_count`='{$p_count["fileList"][$n]["printedCount"]}'";
						$sql.=" WHERE `print_id`='{$print_user[$p_count["fileList"][$n]["fileID"]]}'";
						mysqli_query($mysqli,$sql);
					
					}else{
						$app.="(
							'{$date}',
							'{$print_user[$p_count["fileList"][$n]["fileID"]]}',
							'{$print_id[$p_count["fileList"][$n]["fileID"]]}',
							'{$print_tmpl[$p_count["fileList"][$n]["fileID"]]}',
							'{$p_count["fileList"][$n]["fileID"]}',
							'{$p_count["fileList"][$n]["printedCount"]}'
						),";
					}
				}
			}
		}
	}
}

if($app){
	$sql="INSERT INTO me_print_log(`date`,user_id,making_id,tmpl_id,print_id,print_count) VALUES ";
	$sql.=$app;
	$sql=substr($sql,0,-1);
	mysqli_query($mysqli,$sql);
}
print("Done");
exit;
?>
