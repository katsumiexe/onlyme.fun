<?
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/no_session.php");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}

$list_n["l"]="";
$list_n["n"]="";
$list_n["p"]="";
$list_n["c"]="";

$log="";
$cnt=0;
mysqli_set_charset($mysqli,'UTF-8'); 

$pg		=$_REQUEST['pg']+0;
$cate	=$_REQUEST['cate']+0;

if($pg<1) $pg=1;
$pg_st=($pg-1)*8;
$pg_ed=$pg_st+8;



$sql ="SELECT tmpl_id FROM me_tmpl";
$sql.=" WHERE del<>1";
if($cate>0){
	$sql.=" AND cate0{$cate}=1";
}


$sql.=" ORDER BY tmpl_id DESC"; 
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$tmpl_id=$row["tmpl_id"];
		if($pg_st<=$cnt && $cnt<$pg_ed){

			$sql ="SELECT COUNT(making_id) as cnt, use_tmpl FROM me_making";
			$sql .=" WHERE use_tmpl='{$tmpl_id}'";
			$sql .=" LIMIT 1";

			if($res2 = mysqli_query($mysqli,$sql)){
				$dat2 = mysqli_fetch_assoc($res2);
				$list_n["l"].="<input id=\"cnt{$tmpl_id}\" type=\"hidden\" name=\"cnt\" value=\"{$dat2["cnt"]}\">";
			}

			$list_n["l"].="<div id=\"p{$tmpl_id}\" class=\"fsample\"><img src=\"./img/sample/s{$tmpl_id}.jpg\" class=\"fsample_img img_off\"></div>";
		}
		$cnt++;
	}



	if($pg>1){
		$pg_p=$pg-1;
		$list_n["p"]="<span id=\"pg_p{$pg_p}\" class=\"card_box card_prev\"></span>";
	}else{
		$list_n["p"]="<span class=\"card_box_n card_prev\"></span>";
	}

	if($pg_ed<$cnt){
		$pg_n=$pg+1;
		$list_n["n"].="<span id=\"pg_n{$pg_n}\" class=\"card_box card_next\"></span>";
	}else{
		$list_n["n"].="<span class=\"card_box_n card_next\"></span>";
	}
}

$list_n["st"]=$pg_st;
$list_n["ed"]=$pg_ed;
$list_n["pg"]=$pg;

$pg_cnt=ceil($cnt/8);

for($n=1;$n<$pg_cnt+1;$n++){
	if($n==$pg){
		$nn="it";
	}else{
		$nn="";
	}
	$list_n["c"].="<span id=\"pg_c{$n}\" class=\"card_pg card_box {$nn}\">{$n}</span>";
}

echo json_encode($list_n);
exit;
?>
