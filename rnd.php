<?php
$mysqli = mysqli_connect("localhost", "tiltowait_model", "kk1941", "tiltowait_model");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}

mysqli_set_charset($mysqli,'UTF-8'); 

$d[0]="0";
$d[1]="1";
$d[2]="2";
$d[3]="3";
$d[4]="4";
$d[5]="5";
$d[6]="6";
$d[7]="7";
$d[8]="8";
$d[9]="9";
$d[10]="a";
$d[11]="b";
$d[12]="c";
$d[13]="d";
$d[14]="e";
$d[15]="f";
$d[16]="g";
$d[17]="h";
$d[18]="i";
$d[19]="j";
$d[20]="k";
$d[21]="l";
$d[22]="m";
$d[23]="n";
$d[24]="o";
$d[25]="p";
$d[26]="q";
$d[27]="r";
$d[28]="s";
$d[29]="t";
$d[30]="u";
$d[31]="v";
$d[32]="w";
$d[33]="x";
$d[34]="y";
$d[35]="z";
$p=0;
for($n=0;$n<36;$n++){
    for($s=0;$s<36;$s++){
        $tmp=$d[$n].$d[$s];
        $dat[$p]=$tmp;                    
        $p++;
    }
}
shuffle($dat);
for($q=0;$q<720;$q++){
    $x=$q % 36;
    $y=floor($q / 36);

    $inc.="('{$y}','{$dat[$q]}','{$d[$x]}'),";
    print($y.",".$dat[$q].",".$d[$x].",\n");
}


$inc=substr($inc,0,-1);
$sql="INSERT INTO me_encode(`gp`,`key`,`value`) VALUES";
$sql.=$inc;
//mysqli_query ($mysqli,$sql);
print($sql);
?>