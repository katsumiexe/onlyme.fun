<?
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/session.php");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}

mysqli_set_charset($mysqli,'UTF-8'); 
$next_i		=$_REQUEST['next_i']+0;

$lis="";
$d=0;

$sql ="SELECT * FROM `me_making`";
$sql.=" WHERE `del`='0'";
$sql.=" AND user_id='{$user["id"]}'";
$sql.=" ORDER BY making_id DESC";
$sql.=" LIMIT {$next_i}, 21";

$result = mysqli_query($mysqli,$sql);

while($dat_i = mysqli_fetch_assoc($result)){
    if($d>19){
        $ck=$next_i+20;
        $lis.="<div id=\"next_i{$ck}\" class=\"next\">次へ</div>";
        break;
    }
    $tmp_mdate=substr($dat_i["makedate"],5,2)."/".substr($dat_i["makedate"],8,2)."　".substr($dat_i["makedate"],11,2).":".substr($dat_i["makedate"],14,2);
	$tmp_mimg="./{$dir}/{$dat_i["img"]}";
    $lis.="<div class=\"index_frame\">";
    $lis.="<div class=\"index_frame_ttl\">{$tmp_mdate}</div>";
    $lis.="<img src=\"{$tmp_mimg}\" class=\"index_img\">";
    $lis.="</div>";
    $d++;

}
echo($lis);
?>