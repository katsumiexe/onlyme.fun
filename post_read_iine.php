<?
$mysqli = mysqli_connect("localhost", "tiltowait_model", "kk1941", "tiltowait_model");
mysqli_set_charset($mysqli,'UTF-8'); 

$minus=0;

$img_id	=$_POST["img_id"];
$user_id=$_POST["user_id"];


$res3["s_pritty"]   =0;
$res3["s_smart"]    =0;
$res3["s_funny"]    =0;
$res3["s_sexy"]     =0;

$res3["s_all"]      =0;
$res3["host"]       =0;
$res3["minus"]		=0;

$sql="SELECT * FROM me_iine";
$sql=" LEFT JOIN me_making ON me_iine.i_card_id=me_making.making_id";
$sql.=" WHERE i_card_id='{$img_id}'";
$sql.=" AND me_making.del='0'";

if($result = mysqli_query($mysqli,$sql)){
    while($res2=mysqli_fetch_assoc($result)){

        $res3["s_pritty"]   +=$res2["pritty"]+0;
        $res3["s_smart"]    +=$res2["smart"]+0;
        $res3["s_funny"]    +=$res2["funny"]+0;
        $res3["s_sexy"]     +=$res2["sexy"]+0;

        $res3["s_all"]      +=$res2["sexy"]+$res2["funny"]+$res2["smart"]+$res2["pritty"]+0;
        $res3["host"]       +=$res2["i_host_id"];

        
        if($user_id == $res2["i_user_id"]){
            if($res2["pritty"]>0){
                $res3["mysel"]="pritty";
                $res3["minus"]=$res2["pritty"];

            }elseif($res2["smart"]>0){
                $res3["mysel"]="smart";
                $res3["minus"]=$res2["smart"];
    
            }elseif($res2["funny"]>0){
                $res3["mysel"]="funny";
                $res3["minus"]=$res2["funny"];

            }elseif($res2["sexy"]>0){
                $res3["mysel"]="sexy";
                $res3["minus"]=$res2["sexy"];
            }        
        }
    }
}
echo json_encode($res3);
exit;
?>
