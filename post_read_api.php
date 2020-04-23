<?
include_once("./library/no_session.php");
include_once("./library/api.php");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}

$id	=$_POST["id"];

mysqli_set_charset($mysqli,'UTF-8'); 
$url = "https://api.networkprint.jp/rest/webapi/v2";

$dat1["key"]	= "85B35DD2-7B07-4560-A04B-C564425DDFE8";
$dat1["ver"]	= "2.7";
$dat1["M"]		= "loginForGuest2";

$content = http_build_query($dat1);
$dat2 = array(
	'http' => array(
		'method' => 'POST',
		'content'=> $content
	)
);

$token = file_get_contents($url, false, stream_context_create($dat2));
$token =json_decode($token);
if($token["result"] ==0){
	$sql ="UPDATE me_prof SET";
	$sql.=" api_code='{$token["userCode"]}',";
	$sql.=" api_token='{$token["authToken"]}'";
	$sql.=" WHERE prof_id='{$id}'";
}else{
	echo("ネットワークプリンタの認証にエラーが発生しました");
}
?>
