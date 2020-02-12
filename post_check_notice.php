<?
include_once("./library/lib.php");
include_once("./library/lib_me.php");
include_once("./library/session.php");

$img_id	    =$_POST["img_id"];
$user_id    =$_POST["user_id"];

$res3["s_pritty"]   =0;
$res3["s_smart"]    =0;
$res3["s_funny"]    =0;
$res3["s_sexy"]     =0;

$res3["s_all"]      =0;
$res3["host"]       =0;
$res3["minus"]		=0;

$sql ="SELECT *, sum(me_iine.pritty)as s_pritty, sum(me_iine.smart)as s_smart, sum(me_iine.funny)as s_funny, sum(me_iine.sexy) as s_sexy FROM `me_making`";
$sql.=" LEFT JOIN `me_iine` ON me_making.making_id=i_card_id";
$sql.=" WHERE `me_making`.`making_id`='{$img_id}'";
$sql.=" AND `me_making`.`del`='0'";
$sql.=" GROUP BY me_making.making_id";

if($result = mysqli_query($mysqli,$sql)){
    while($res2=mysqli_fetch_assoc($result)){

        $res3["s_pritty"]   +=$res2["pritty"]+0;
        $res3["s_smart"]    +=$res2["smart"]+0;
        $res3["s_funny"]    +=$res2["funny"]+0;
        $res3["s_sexy"]     +=$res2["sexy"]+0;
        $res3["s_all"]      +=$res2["sexy"]+$res2["funny"]+$res2["smart"]+$res2["pritty"]+0;
        $res3["host"]       +=$res2["i_host_id"];
        $res3["url"]         =$dir."/".$res2["img"];
        $res3["mdate"] =substr($res2["makedate"],5,2)."/".substr($res2["makedate"],8,2)." ".substr($res2["makedate"],11,2).":".substr($res2["makedate"],14,2);
    }
}
echo json_encode($res3);
exit;
?>


