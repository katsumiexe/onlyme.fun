<?
$mysqli = mysqli_connect("localhost", "tiltowait_model", "kk1941", "tiltowait_model");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}
mysqli_set_charset($mysqli,'UTF-8'); 

session_save_path('./session/');
ini_set('session.gc_maxlifetime', 3*60*60); // 3 hours
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.cookie_secure', FALSE);
ini_set('session.use_only_cookies', TRUE);
session_start();
//header('Expires:-1');
//header('Cache-Control:');
//header('Pragma:');


$day = date("Ymd");
$date = date("Y-m-d H:i:s");
$token=$_SESSION["token"];
$sql ="SELECT * FROM encode"; 
$result = mysqli_query($mysqli,$sql);
while($row = mysqli_fetch_assoc($result)){
	$enc[$row["key"]]	=$row["value"];
	$dec[$row["value"]]	=$row["key"];
}

$log_in		=$_REQUEST["log_in"];
$log_pass	=$_REQUEST["log_pass"];
$easy		=$_REQUEST["easy"];
$exp=0;

if($easy){

	$sql ="SELECT * FROM me_encode"; 
	if($enc_1 = mysqli_query($mysqli,$sql)){
		while($enc_2 = mysqli_fetch_assoc($enc_1)){
			$me_enc[$enc_2["key"]]=$enc_2["value"];

		}
	}

	$easy_cnt=floor(strlen($easy)/2);
	for($s=0;$s<8;$s++){
		$tmp=substr($easy,$s*2,2);
		$log_in.=$me_enc[$tmp];
	}

	for($s=8;$s<$easy_cnt;$s++){
		$tmp=substr($easy,$s*2,2);
		$log_pass.=$me_enc[$tmp];
	}
}

if ($log_in || $log_pass){
	$sql="SELECT * from `reg` WHERE (`id`='{$log_in}' OR `reg_mail`='{$log_in}') AND `reg_pass`='{$log_pass}'";
	$result = mysqli_query($mysqli,$sql);
	$user = mysqli_fetch_assoc($result);

	if($user){
		if($user["reg_rank"] >10){
			$_SESSION	=$user;
			$_SESSION["time"]= time();

			$log_no=100;
			$log_user=$_SESSION["id"];
/*			
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

			$j_token = file_get_contents($url, false, stream_context_create($dat2));
			if($j_token){
				$n_token =json_decode($j_token);

				foreach($n_token as $aa1 => $aa2){
					$dat_token[$aa1]=$aa2;
				}

				if($dat_token["result"] ==0){
					$api_now	=date("Y-m-d");
					$api_code	=$dat_token["userCode"];
					$api_token	=$dat_token["authToken"];

					$sql ="UPDATE me_prof SET";
					$sql.=" api_date='{$api_now}',";
					$sql.=" api_code='{$api_code}',";
					$sql.=" api_token='{$api_token}'";
					$sql.=" WHERE prof_id='{$user["id"]}'";
					mysqli_query($mysqli,$sql);
				}else{	
					$err="ネットワークプリンタの認証にエラーが発生しました";
				}
			}
*/

		}elseif($user["reg_rank"] == 2){
			$msg="こちらのIDは退会されています";

		}elseif($user["reg_rank"] == 3){
			$msg="こちらのIDの利用は停止されています";

		}else{
			$msg="IDもしくはPASSが違います。";
		}
	}else{
		$msg="IDまたはPASSが違います。";
	}
}else{

	if($_SESSION["time"]+18000 > time()){
		$sql="SELECT * FROM `reg` WHERE `id`='{$_SESSION["id"]}' AND reg_rank>'10'";
		$result = mysqli_query($mysqli,$sql);
		$user = mysqli_fetch_assoc($result);

		$_SESSION	=$user;
		$_SESSION["time"]		= time();

		$log_no=100;
		$log_user=$_SESSION["id"];

	}else{
		if($_SESSION){
		$msg="タイムアウトしました。";
		}
		$log_no=202;
		$log_user=$_SESSION["id"];

		$_SESSION = array();
		session_destroy(); 
	}
}

if($_REQUEST["logout"]){
	if($_SESSION["id"]){
		$_SESSION = array();
		session_destroy(); 
	}
	$msg="LOG OUTしました";
	$log_no=201;
	$log_user=$_SESSION["id"];
}

if($user){
	$sql ="SELECT * FROM me_prof WHERE prof_id='{$_SESSION["id"]}'"; 
	$sql .="LIMIT 1"; 
	$result = mysqli_query($mysqli,$sql);
	$prof = mysqli_fetch_assoc($result);

	//■------------------------
	for($n=0;$n<4;$n++){
		$tmp_key=substr($user["id"],$n*2,2);
		$tmp_enc[$n]=$enc[$tmp_key];
	}
	//■------------------------

	$user_enc_id=$tmp_enc[0].$tmp_enc[3].$tmp_enc[1].$tmp_enc[2].$tmp_enc[3].$tmp_enc[2];
	$dir="myalbum/{$tmp_enc[3]}/{$user_enc_id}/{$tmp_enc[2]}{$tmp_enc[3]}/";//album
	$dir2="myalbum/{$tmp_enc[3]}/{$user_enc_id}/{$tmp_enc[1]}{$tmp_enc[3]}/";//card
	$dir3="myalbum/{$tmp_enc[3]}/{$user_enc_id}/{$tmp_enc[3]}{$tmp_enc[2]}/";//prof

	$tmp=substr("0".$tmp_key+1,-2,2);
	$prof_1=$enc[$tmp].".jpg";

	$tmp=substr("0".$tmp_key+2,-2,2);
	$prof_2=$enc[$tmp].".jpg";

	$tmp=substr("0".$tmp_key+3,-2,2);
	$prof_3=$enc[$tmp].".jpg";

	if(file_exists($dir3.$prof_1)){
		$prof_img[1]=$dir3.$prof_1;
	}else{
		$prof_img[1]="img/noimage{$user['reg_sex']}.png";
	}

	if(file_exists($dir3.$prof_2)){
		$prof_img[2]=$dir3.$prof_2;
	}else{
		$prof_img[2]="img/noimage{$user['reg_sex']}.png";
	}

	if(file_exists($dir3.$prof_3)){
		$prof_img[3]=$dir3.$prof_3;
	}else{
		$prof_img[3]="img/noimage{$user['reg_sex']}.png";
	}

	if(!file_exists($dir)){
		mkdir($dir, 0777, TRUE);
		chmod($dir, 0777);

		mkdir($dir2, 0777, TRUE);
		chmod($dir2, 0777);

		mkdir($dir3, 0777, TRUE);
		chmod($dir3, 0777);
	}

	$tmp = str_replace("-", "", $user['reg_birth']);
	$user_age= floor(($day-$tmp)/10000);

	if($user['reg_pic']>0){
		$user_face=$prof_img[$user['reg_pic']];
		$add_exp=20;

	}else{
		$user_face="./img/noimage{$user['reg_sex']}.png";
		$add_exp=10;	
	}

	$sql ="SELECT";
	$sql.=" c_host_id, COUNT(c_card_id) as s_cheer";
	$sql.=" FROM `me_cheer`";
	$sql.=" WHERE c_host_id='{$user["id"]}'";
	$sql.=" AND del='0'";
	$sql.=" AND com !=''";
	$sql.=" GROUP BY c_host_id";

	$res = mysqli_query($mysqli,$sql);
	$res2 = mysqli_fetch_assoc($res);
	$user["s_cheer"]=$res2["s_cheer"];

	$sql ="SELECT";
	$sql .=" sum(me_iine.pritty) as s_pritty,";
	$sql .=" sum(me_iine.smart) as s_smart,";
	$sql .=" sum(me_iine.funny) as s_funny,";
	$sql .=" sum(me_iine.sexy) as s_sexy";
	$sql .=" FROM `me_iine`";
	$sql .=" WHERE i_host_id='{$user["id"]}'";
	$sql .=" GROUP BY i_host_id";

	$res = mysqli_query($mysqli,$sql);
	$res2 = mysqli_fetch_assoc($res);
	$user["s_pritty"]	=$res2["s_pritty"];
	$user["s_smart"]	=$res2["s_smart"];
	$user["s_funny"]	=$res2["s_funny"];
	$user["s_sexy"]		=$res2["s_sexy"];

	$sql ="SELECT";
	$sql .=" count(fav_id) as s_fav";
	$sql .=" FROM `me_fav`";
	$sql .=" WHERE fav_user_id='{$user["id"]}'";
	$sql .=" GROUP BY fav_user_id";

	$res = mysqli_query($mysqli,$sql);
	$res2 = mysqli_fetch_assoc($res);
	$user["s_favd"]	=$res2["s_favd"];

	$sql ="SELECT";
	$sql .=" count(fav_id) as s_favd";
	$sql .=" FROM `me_fav`";
	$sql .=" WHERE fav_host_id='{$user["id"]}'";
	$sql .=" GROUP BY fav_host_id";

	$res = mysqli_query($mysqli,$sql);
	$res2 = mysqli_fetch_assoc($res);
	$user["s_fav"]	=$res2["s_fav"];

//---------------------------------------------------------------
	//■ログイン加算

	$sql_log="insert into log(`date`,`day`,`log_no`,`user_id`,`exp`)";
	$sql_log.=" VALUES('{$date}','{$day}','{$log_no}','{$log_user}',{$add_exp})";
	mysqli_query($mysqli,$sql_log);

	$sql2 ="SELECT count(log_id) as cnt, log_no, max(exp) as m_exp, day, action FROM log"; 
	$sql2.=" WHERE user_id='{$_SESSION["id"]}'";
	$sql2.=" GROUP BY day,log_no";

	$result2 = mysqli_query($mysqli,$sql2);

	while($row2 = mysqli_fetch_assoc($result2)){

		if($row2["log_no"] == 300){
			if($row2["cnt"]>10){
				$row2["cnt"]=10;
			}
			$exp+=	$row2["cnt"];

		}elseif($row2["log_no"] == 301){

			if($row2["cnt"]>5){
				$row2["cnt"]=5;
			}
			$exp+=	$row2["cnt"]*2;

		}elseif($row2["log_no"] == 302){
			$making+=$row2["cnt"];
			if($row2["cnt"]>2){
				$row2["cnt"]=2;
			}
			$exp+=	$row2["cnt"]*5;

		}else{
			$exp+=	$row2["m_exp"];
		}
	}

	$iine_pt=1;
	if($exp >=200){
		$iine_pt++;
	}

	if($exp >=300){
		$iine_pt++;
	}

	if($exp >=500){
		$iine_pt++;
	}

	$lv=floor($exp/100)+1;
}


if(!$_SESSION["id"] && $page_index !="top"){
	$url = 'https://onlyme.fun';
	header('Location: ' . $url, true, 301);
	exit;
}

function get_after($get_time){
	$tmp_tl="";
	$tmp_tl=time()-strtotime($get_time);
	if($tmp_tl<60){
		return "1分前";
		exit();

	}elseif($tmp_tl<3600){
		return (floor($tmp_tl/300) * 5)."分前";
		exit();

	}elseif($tmp_tl<86400){
		return floor($tmp_tl/3600)."時間前";
		exit();

	}elseif($tmp_tl<604800){
		return floor($tmp_tl/86400)."日前";
		exit();

	}else{
		return "7日以上";
		exit();
	}	
}
?>
