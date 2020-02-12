<?php
include_once("../library/lib_me.php");

$mysqli = mysqli_connect("localhost", "tiltowait_model", "kk1941", "tiltowait_model");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}
mysqli_set_charset($mysqli,'UTF-8'); 



$sel_d[0]="横";
$sel_d[1]="縦";


$sel_name_p[1]="上左";
$sel_name_p[2]="上中";
$sel_name_p[3]="上右";

$sel_name_p[4]="下左";
$sel_name_p[5]="下中";
$sel_name_p[6]="下右";

$ct[1]="女子";
$ct[2]="男子";
$ct[3]="和風";
$ct[4]="自然";
$ct[5]="季節";
$ct[6]="厨二";
$ct[7]="ネタ";


$select		=$_REQUEST["select"];
$send		=$_REQUEST["send"];
$app		=$_REQUEST["app"];
$tmpl_sel	=$_REQUEST["tmpl_sel"];

if($_POST["send"]){

if($tmpl_sel){
$select=$tmpl_sel;

$sql.="UPDATE me_tmpl SET 
tmpl_name='{$app["tmpl_name"]}',

cate01='{$app["cate01"]}',
cate02='{$app["cate02"]}',
cate03='{$app["cate03"]}',
cate04='{$app["cate04"]}',
cate05='{$app["cate05"]}',
cate06='{$app["cate06"]}',
cate07='{$app["cate07"]}',
cate08='{$app["cate08"]}',
form='{$app["form"]}',
name_color='{$app["name_color"]}',
name_font='{$app["name_font"]}',
name_size='{$app["name_size"]}',
name_d='{$app["name_d"]}',
name_r='{$app["name_r"]}',
name_p='{$app["name_p"]}',
name_x='{$app["name_x"]}',
name_y='{$app["name_y"]}',
name_z='{$app["name_z"]}',
name_line_color='{$app["name_line_color"]}',
name_line_size='{$app["name_line_size"]}',
name_shadow_color='{$app["name_shadow_color"]}',
name_shadow_size='{$app["name_shadow_size"]}',
orgin_d='{$app["orgin_d"]}',
orgin_r='{$app["orgin_r"]}',
orgin_p='{$app["orgin_p"]}',
orgin_x='{$app["orgin_x"]}',
orgin_y='{$app["orgin_y"]}',
orgin_z='{$app["orgin_z"]}',
orgin_color='{$app["orgin_color"]}',
orgin_font='{$app["orgin_font"]}',
orgin_size='{$app["orgin_size"]}',
orgin_line_color='{$app["orgin_line_color"]}',
orgin_line_size='{$app["orgin_line_size"]}',
contact='{$app["contact"]}',
contact_o='{$app["contact_o"]}',
contact_color='{$app["contact_color"]}',
contact_icon_color='{$app["contact_icon_color"]}',
contact_line_color='{$app["contact_line_color"]}',
contact_line_size='{$app["contact_line_size"]}',
contact_shadow_color='{$app["contact_shadow_color"]}',
contact_shadow_size='{$app["contact_shadow_size"]}',
contact_width='{$app["contact_width"]}',
contact_height='{$app["contact_height"]}',
contact_x='{$app["contact_x"]}',
contact_y='{$app["contact_y"]}',
contact_z='{$app["contact_z"]}',
contact_p='{$app["contact_p"]}',

qr_p='{$app["qr_p"]}',
qr_x='{$app["qr_x"]}',
qr_y='{$app["qr_y"]}',
qr_base='{$app["qr_base"]}',
qr_top='{$app["qr_top"]}',

wall0='{$app["wall0"]}',
wall0_o='{$app["wall0_o"]}',
wall0_x='{$app["wall0_x"]}',
wall0_y='{$app["wall0_y"]}',
wall0_z='{$app["wall0_z"]}',
wall0_w='{$app["wall0_w"]}',
wall0_h='{$app["wall0_h"]}',
wall0_l='{$app["wall0_l"]}',

wall1='{$app["wall1"]}',
wall1_o='{$app["wall1_o"]}',
wall1_x='{$app["wall1_x"]}',
wall1_y='{$app["wall1_y"]}',
wall1_z='{$app["wall1_z"]}',
wall1_w='{$app["wall1_w"]}',
wall1_h='{$app["wall1_h"]}',
wall1_l='{$app["wall1_l"]}',

wall2='{$app["wall2"]}',
wall2_o='{$app["wall2_o"]}',
wall2_x='{$app["wall2_x"]}',
wall2_y='{$app["wall2_y"]}',
wall2_z='{$app["wall2_z"]}',
wall2_w='{$app["wall2_w"]}',
wall2_h='{$app["wall2_h"]}',
wall2_l='{$app["wall2_l"]}',

wall3='{$app["wall3"]}',
wall3_o='{$app["wall3_o"]}',
wall3_x='{$app["wall3_x"]}',
wall3_y='{$app["wall3_y"]}',
wall3_z='{$app["wall3_z"]}',
wall3_w='{$app["wall3_w"]}',
wall3_h='{$app["wall3_h"]}',
wall3_l='{$app["wall3_l"]}',

frame0='{$app["frame0"]}',
frame0_o='{$app["frame0_o"]}',
frame0_w='{$app["frame0_w"]}',
frame0_z='{$app["frame0_z"]}',

frame1='{$app["frame1"]}',
frame1_o='{$app["frame1_o"]}',
frame1_w='{$app["frame1_w"]}',
frame1_z='{$app["frame1_z"]}'
 WHERE tmpl_id='{$tmpl_sel}'";

}else{
$sql="INSERT INTO `me_tmpl`";
$sql.="(
tmpl_name,
category,
cate01,
cate02,
cate03,
cate04,
cate05,
cate06,
cate07,
cate08,
form,
name_color,
name_font,
name_size,
name_d,
name_r,
name_p,
name_x,
name_y,
name_z,
name_line_color,
name_line_size,
name_shadow_color,
name_shadow_size,
orgin_d,
orgin_r,
orgin_p,
orgin_x,
orgin_y,
orgin_z,
orgin_color,
orgin_font,
orgin_size,
orgin_line_color,
orgin_line_size,
contact,
contact_o,
contact_color,
contact_icon_color,
contact_line_color,
contact_line_size,
contact_shadow_color,
contact_shadow_size,
contact_width,
contact_height,
contact_x,
contact_y,
contact_z,
contact_p,
qr_p,
qr_x,
qr_y,
qr_base,
qr_top,
wall0,
wall0_o,
wall0_x,
wall0_y,
wall0_z,
wall0_w,
wall0_h,
wall0_l,
wall1,
wall1_o,
wall1_x,
wall1_y,
wall1_z,
wall1_w,
wall1_h,
wall1_l,
wall2,
wall2_o,
wall2_x,
wall2_y,
wall2_z,
wall2_w,
wall2_h,
wall2_l,
wall3,
wall3_o,
wall3_x,
wall3_y,
wall3_z,
wall3_w,
wall3_h,
wall3_l,
frame0,
frame0_o,
frame0_w,
frame0_z,
frame1,
frame1_o,
frame1_w,
frame1_z
)";

$sql.="values(
'{$app["tmpl_name"]}',
'{$app["category"]}',

'{$app["cate01"]}',
'{$app["cate02"]}',
'{$app["cate03"]}',
'{$app["cate04"]}',
'{$app["cate05"]}',
'{$app["cate06"]}',
'{$app["cate07"]}',
'{$app["cate08"]}',

'{$app["form"]}',
'{$app["name_color"]}',
'{$app["name_font"]}',
'{$app["name_size"]}',
'{$app["name_d"]}',
'{$app["name_r"]}',
'{$app["name_p"]}',
'{$app["name_x"]}',
'{$app["name_y"]}',
'{$app["name_z"]}',
'{$app["name_line_color"]}',
'{$app["name_line_size"]}',
'{$app["name_shadow_color"]}',
'{$app["name_shadow_size"]}',
'{$app["orgin_d"]}',
'{$app["orgin_r"]}',
'{$app["orgin_p"]}',
'{$app["orgin_x"]}',
'{$app["orgin_y"]}',
'{$app["orgin_z"]}',
'{$app["orgin_color"]}',
'{$app["orgin_font"]}',
'{$app["orgin_size"]}',
'{$app["orgin_line_color"]}',
'{$app["orgin_line_size"]}',
'{$app["contact"]}',
'{$app["contact_o"]}',
'{$app["contact_color"]}',
'{$app["contact_icon_color"]}',
'{$app["contact_line_color"]}',
'{$app["contact_line_size"]}',
'{$app["contact_shadow_color"]}',
'{$app["contact_shadow_size"]}',
'{$app["contact_width"]}',
'{$app["contact_height"]}',
'{$app["contact_x"]}',
'{$app["contact_y"]}',
'{$app["contact_z"]}',
'{$app["contact_p"]}',

'{$app["qr_p"]}',
'{$app["qr_x"]}',
'{$app["qr_y"]}',
'{$app["qr_base"]}',
'{$app["qr_top"]}',

'{$app["wall0"]}',
'{$app["wall0_o"]}',
'{$app["wall0_x"]}',
'{$app["wall0_y"]}',
'{$app["wall0_z"]}',
'{$app["wall0_w"]}',
'{$app["wall0_h"]}',
'{$app["wall0_l"]}',
'{$app["wall1"]}',
'{$app["wall1_o"]}',
'{$app["wall1_x"]}',
'{$app["wall1_y"]}',
'{$app["wall1_z"]}',
'{$app["wall1_w"]}',
'{$app["wall1_h"]}',
'{$app["wall1_l"]}',
'{$app["wall2"]}',
'{$app["wall2_o"]}',
'{$app["wall2_x"]}',
'{$app["wall2_y"]}',
'{$app["wall2_z"]}',
'{$app["wall2_w"]}',
'{$app["wall2_h"]}',
'{$app["wall2_l"]}',
'{$app["wall3"]}',
'{$app["wall3_o"]}',
'{$app["wall3_x"]}',
'{$app["wall3_y"]}',
'{$app["wall3_z"]}',
'{$app["wall3_w"]}',
'{$app["wall3_h"]}',
'{$app["wall3_l"]}',
'{$app["frame0"]}',
'{$app["frame0_o"]}',
'{$app["frame0_w"]}',
'{$app["frame0_z"]}',
'{$app["frame1"]}',
'{$app["frame1_o"]}',
'{$app["frame1_w"]}',
'{$app["frame1_z"]}')";
}
mysqli_query($mysqli,$sql);
}
//print($sql);

$n=0;
$sql="SELECT * FROM `me_tmpl`";
$result = mysqli_query($mysqli,$sql);

if($result){
	while($row = mysqli_fetch_assoc($result)){

	//	if(!$select) $select=max($row["tmpl_id"]);

		$dat[$row["tmpl_id"]]["tmpl_name"]		=$row["tmpl_name"];	
		$dat[$row["tmpl_id"]]["category"]		=$row["category"];	



		$dat[$row["tmpl_id"]]["form"]		=$row["form"];	

		if($select === $row["tmpl_id"]){

			$dat[$row["tmpl_id"]]["cate01"]		=$row["cate01"];	
			$dat[$row["tmpl_id"]]["cate02"]		=$row["cate02"];	
			$dat[$row["tmpl_id"]]["cate03"]		=$row["cate03"];	
			$dat[$row["tmpl_id"]]["cate04"]		=$row["cate04"];	
			$dat[$row["tmpl_id"]]["cate05"]		=$row["cate05"];	
			$dat[$row["tmpl_id"]]["cate06"]		=$row["cate06"];	
			$dat[$row["tmpl_id"]]["cate07"]		=$row["cate07"];	
			$dat[$row["tmpl_id"]]["cate08"]		=$row["cate08"];	

			$dat[$row["tmpl_id"]]["name_color"]		=$row["name_color"];	
			$dat[$row["tmpl_id"]]["name_font"]		=$row["name_font"];	
			$dat[$row["tmpl_id"]]["name_size"]		=$row["name_size"];	
			$dat[$row["tmpl_id"]]["name_d"]			=$row["name_d"];	
			$dat[$row["tmpl_id"]]["name_r"]			=$row["name_r"];	
			$dat[$row["tmpl_id"]]["name_p"]			=$row["name_p"];	
			$dat[$row["tmpl_id"]]["name_x"]			=$row["name_x"];	
			$dat[$row["tmpl_id"]]["name_y"]			=$row["name_y"];	
			$dat[$row["tmpl_id"]]["name_z"]			=$row["name_z"];	
			$dat[$row["tmpl_id"]]["name_line_color"]	=$row["name_line_color"];	
			$dat[$row["tmpl_id"]]["name_line_size"]		=$row["name_line_size"];	
			$dat[$row["tmpl_id"]]["name_shadow_color"]	=$row["name_shadow_color"];	
			$dat[$row["tmpl_id"]]["name_shadow_size"]	=$row["name_shadow_size"];	
				
			$dat[$row["tmpl_id"]]["orgin_color"]	=$row["orgin_color"];	
			$dat[$row["tmpl_id"]]["orgin_line_color"]	=$row["orgin_line_color"];	
			$dat[$row["tmpl_id"]]["orgin_line_size"]	=$row["orgin_line_size"];	
			$dat[$row["tmpl_id"]]["orgin_font"]		=$row["orgin_font"];	
			$dat[$row["tmpl_id"]]["orgin_size"]		=$row["orgin_size"];	
			$dat[$row["tmpl_id"]]["orgin_d"]		=$row["orgin_d"];	
			$dat[$row["tmpl_id"]]["orgin_r"]		=$row["orgin_r"];	
			$dat[$row["tmpl_id"]]["orgin_p"]		=$row["orgin_p"];	
			$dat[$row["tmpl_id"]]["orgin_x"]		=$row["orgin_x"];	
			$dat[$row["tmpl_id"]]["orgin_y"]		=$row["orgin_y"];	
			$dat[$row["tmpl_id"]]["orgin_z"]		=$row["orgin_z"];	

			$dat[$row["tmpl_id"]]["contact"]		=$row["contact"];	
			$dat[$row["tmpl_id"]]["contact_o"]		=$row["contact_o"];	
			$dat[$row["tmpl_id"]]["contact_color"]	=$row["contact_color"];	
			$dat[$row["tmpl_id"]]["contact_icon_color"]	=$row["contact_icon_color"];	
			$dat[$row["tmpl_id"]]["contact_line_color"]	=$row["contact_line_color"];	
			$dat[$row["tmpl_id"]]["contact_line_size"]	=$row["contact_line_size"];	
			$dat[$row["tmpl_id"]]["contact_shadow_color"]	=$row["contact_shadow_color"];	
			$dat[$row["tmpl_id"]]["contact_shadow_size"]	=$row["contact_shadow_size"];	
			$dat[$row["tmpl_id"]]["contact_width"]	=$row["contact_width"];	
			$dat[$row["tmpl_id"]]["contact_height"]	=$row["contact_height"];	
			$dat[$row["tmpl_id"]]["contact_x"]		=$row["contact_x"];	
			$dat[$row["tmpl_id"]]["contact_y"]		=$row["contact_y"];	
			$dat[$row["tmpl_id"]]["contact_z"]		=$row["contact_z"];	
			$dat[$row["tmpl_id"]]["contact_p"]		=$row["contact_p"];	

			$dat[$row["tmpl_id"]]["qr_p"]		=$row["qr_p"];	
			$dat[$row["tmpl_id"]]["qr_y"]		=$row["qr_y"];	
			$dat[$row["tmpl_id"]]["qr_x"]		=$row["qr_x"];	
			$dat[$row["tmpl_id"]]["qr_base"]	=$row["qr_base"];	
			$dat[$row["tmpl_id"]]["qr_top"]		=$row["qr_top"];	

			$dat[$row["tmpl_id"]]["wall0"]		=$row["wall0"];	
			$dat[$row["tmpl_id"]]["wall0_o"]	=$row["wall0_o"];	
			$dat[$row["tmpl_id"]]["wall0_w"]	=$row["wall0_w"];	
			$dat[$row["tmpl_id"]]["wall0_h"]	=$row["wall0_h"];	
			$dat[$row["tmpl_id"]]["wall0_x"]	=$row["wall0_x"];
			$dat[$row["tmpl_id"]]["wall0_y"]	=$row["wall0_y"];
			$dat[$row["tmpl_id"]]["wall0_z"]	=$row["wall0_z"];
			$dat[$row["tmpl_id"]]["wall0_l"]	=$row["wall0_l"];


			$dat[$row["tmpl_id"]]["wall1"]		=$row["wall1"];	
			$dat[$row["tmpl_id"]]["wall1_o"]	=$row["wall1_o"];	
			$dat[$row["tmpl_id"]]["wall1_w"]	=$row["wall1_w"];	
			$dat[$row["tmpl_id"]]["wall1_h"]	=$row["wall1_h"];	
			$dat[$row["tmpl_id"]]["wall1_x"]	=$row["wall1_x"];
			$dat[$row["tmpl_id"]]["wall1_y"]	=$row["wall1_y"];
			$dat[$row["tmpl_id"]]["wall1_z"]	=$row["wall1_z"];
			$dat[$row["tmpl_id"]]["wall1_l"]	=$row["wall1_l"];


			$dat[$row["tmpl_id"]]["wall2"]		=$row["wall2"];	
			$dat[$row["tmpl_id"]]["wall2_o"]	=$row["wall2_o"];	
			$dat[$row["tmpl_id"]]["wall2_w"]	=$row["wall2_w"];	
			$dat[$row["tmpl_id"]]["wall2_h"]	=$row["wall2_h"];	
			$dat[$row["tmpl_id"]]["wall2_x"]	=$row["wall2_x"];
			$dat[$row["tmpl_id"]]["wall2_y"]	=$row["wall2_y"];
			$dat[$row["tmpl_id"]]["wall2_z"]	=$row["wall2_z"];
			$dat[$row["tmpl_id"]]["wall2_l"]	=$row["wall2_l"];


			$dat[$row["tmpl_id"]]["wall3"]		=$row["wall3"];	
			$dat[$row["tmpl_id"]]["wall3_o"]	=$row["wall3_o"];	
			$dat[$row["tmpl_id"]]["wall3_w"]	=$row["wall3_w"];	
			$dat[$row["tmpl_id"]]["wall3_h"]	=$row["wall3_h"];	
			$dat[$row["tmpl_id"]]["wall3_x"]	=$row["wall3_x"];
			$dat[$row["tmpl_id"]]["wall3_y"]	=$row["wall3_y"];
			$dat[$row["tmpl_id"]]["wall3_z"]	=$row["wall3_z"];
			$dat[$row["tmpl_id"]]["wall3_l"]	=$row["wall3_l"];

			$dat[$row["tmpl_id"]]["frame0"]		=$row["frame0"];	
			$dat[$row["tmpl_id"]]["frame0_o"]	=$row["frame0_o"];	
			$dat[$row["tmpl_id"]]["frame0_w"]	=$row["frame0_w"];	
			$dat[$row["tmpl_id"]]["frame0_z"]	=$row["frame0_z"];	

			$dat[$row["tmpl_id"]]["frame1"]		=$row["frame1"];	
			$dat[$row["tmpl_id"]]["frame1_o"]	=$row["frame1_o"];	
			$dat[$row["tmpl_id"]]["frame1_w"]	=$row["frame1_w"];	
			$dat[$row["tmpl_id"]]["frame1_z"]	=$row["frame1_z"];	


		}
	}
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ja">
<head>
<style>
table{
	border: solid 1px #000000;
	border-collapse: collapse;
	margin:5px;
}

td{
border:1px solid #909090;
text-align:left;
padding:2px;
font-size:12px;
}


.cate{
	display:inline-block;
	width:65px;
	text-align:left;
	background:#e0e0e0;
	border:1px solid #d0d0d0
}

</style>
</head>
<body>
<form method="post" action="./z_factory.php">
<input type="text" value="<?=$select?>" name="tmpl_sel" style="width:40px">　
<button type="submit" name="send" value="send">SEND</button><br>

<hr>

<div style="float:left; width:250px; text-align:center;margin:3px;">
<table>
<tr>
<td>ID</td>
<td>NAME</td>
<td>CATE</td>
<td>FORM</td>
</tr>
<?foreach((array)$dat as $a1 => $a2){?>
<tr>
<td><?=$a1?></td>
<td><a href="./z_factory.php?select=<?=$a1?>"><?=$dat[$a1]["tmpl_name"]?></a></td>
<td><?=$dat[$a1]["category"]?></td>
<td><?=$dat[$a1]["form"]?></td>
</tr>
<?}?>
</table>
</div>
<div style="float:left; width:300px; text-align:center;margin:3px;">
<table>
<tr>
<td colspan="2" style="background:#e0e0e0">TMPL</td>
</tr>

<tr>
<td style="width:100px; text-align:left" >name</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[tmpl_name]" value=<?=$dat[$select]["tmpl_name"]?>></td>
</tr>
<tr>

<tr>
<td style="width:100px; text-align:left" >FORM</td>
<td style="width:200px; text-align:left" >
<select style="width:100%;" name="app[form]">
<option value="0" <?if(0 == $dat[$select]["form"]){?>selected="selected"<?}?>>縦</option>
<option value="1" <?if(1 == $dat[$select]["form"]){?>selected="selected"<?}?>>横</option>
</select>
</td>
</tr>
<tr>
<td colspan="2" >
<label class="cate"><input type="checkbox" name="app[cate01]" value="1" <?if($dat[$select]["cate01"] == 1){?>checked="checked"<?}?>><?=$ct[1]?></label><!--
--><label class="cate"><input type="checkbox" name="app[cate02]" value="1" <?if($dat[$select]["cate02"] == 1){?>checked="checked"<?}?>><?=$ct[2]?></label><!--
--><label class="cate"><input type="checkbox" name="app[cate03]" value="1" <?if($dat[$select]["cate03"] == 1){?>checked="checked"<?}?>><?=$ct[3]?></label><!--
--><label class="cate"><input type="checkbox" name="app[cate04]" value="1" <?if($dat[$select]["cate04"] == 1){?>checked="checked"<?}?>><?=$ct[4]?></label><br>
<label class="cate"><input type="checkbox" name="app[cate05]" value="1" <?if($dat[$select]["cate05"] == 1){?>checked="checked"<?}?>><?=$ct[5]?></label><!--
--><label class="cate"><input type="checkbox" name="app[cate06]" value="1" <?if($dat[$select]["cate06"] == 1){?>checked="checked"<?}?>><?=$ct[6]?></label><!--
--><label class="cate"><input type="checkbox" name="app[cate07]" value="1" <?if($dat[$select]["cate07"] == 1){?>checked="checked"<?}?>><?=$ct[7]?></label><!--
--><label class="cate"><input type="checkbox" name="app[cate08]" value="1" <?if($dat[$select]["cate08"] == 1){?>checked="checked"<?}?>><?=$ct[1]?></label>
</td>
</tr>
</table>

<table>
<tr>
<td colspan="2" style="background:#e0e0e0">NAME</td>
</tr>
<tr>
<td style="width:100px; text-align:left" >Z-INDEX</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[name_z]" value=<?=$dat[$select]["name_z"]?>></td>
</tr>
<tr>
<td>FONT</td>
<td>
<select style="width:195px;" name="app[name_font]">
<?foreach($font_name as $a1 => $a2){?>
<option value="<?=$a1?>" <?if($a1 == $dat[$select]["name_font"]){?>selected="selected"<?}?>><?=$a1?>:<?=$a2?></option>
<?}?>
</select>
</td>
</tr>

<tr>
<td style="width:100px; text-align:left" >COLOR</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[name_color]" value=<?=$dat[$select]["name_color"]?>></td>
</tr>


<tr>
<td style="width:100px; text-align:left" >SIZE</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[name_size]" value=<?=$dat[$select]["name_size"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >POSITION</td>
<td>
<select style="width:195px;" name="app[name_p]">
<option value="1" <?if(1 == $dat[$select]["name_p"]){?>selected="selected"<?}?>>1:左上</option>
<option value="2" <?if(2 == $dat[$select]["name_p"]){?>selected="selected"<?}?>>2:中上</option>
<option value="3" <?if(3 == $dat[$select]["name_p"]){?>selected="selected"<?}?>>3:右上</option>
<option value="4" <?if(4 == $dat[$select]["name_p"]){?>selected="selected"<?}?>>4:左下</option>
<option value="5" <?if(5 == $dat[$select]["name_p"]){?>selected="selected"<?}?>>5:中下</option>
<option value="6" <?if(6 == $dat[$select]["name_p"]){?>selected="selected"<?}?>>6:右下</option>
</select>
</td>
</tr>

<tr>
<td style="width:100px; text-align:left" >X</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[name_x]" value=<?=$dat[$select]["name_x"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >Y</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[name_y]" value=<?=$dat[$select]["name_y"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >l_COLOR</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[name_line_color]" value=<?=$dat[$select]["name_line_color"]?>></td>
</tr>
<tr>
<td style="width:100px; text-align:left" >l_size</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[name_line_size]" value=<?=$dat[$select]["name_line_size"]?>></td>
</tr>
<tr>
<td style="width:100px; text-align:left" >s_COLOR</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[name_shadow_color]" value=<?=$dat[$select]["name_shadow_color"]?>></td>
</tr>
<tr>
<td style="width:100px; text-align:left" >s_size</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[name_shadow_size]" value=<?=$dat[$select]["name_shadow_size"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >Direction</td>
<td>
<select style="width:195px;" name="app[name_d]">
<option value="0" <?if(0 == $dat[$select]["name_d"]){?>selected="selected"<?}?>>0:横書き</option>
<option value="1" <?if(1 == $dat[$select]["name_d"]){?>selected="selected"<?}?>>1:縦書き</option>
</select>
</td>
</tr>
<tr>
<td style="width:100px; text-align:left" >Rotate</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[name_r]" value=<?=$dat[$select]["name_r"]?>></td>
</tr>


</table>

<table>
<tr>
<td colspan="2" style="background:#e0e0e0">ORGIN</td>
</tr>

<tr>
<td style="width:100px; text-align:left" >Z-INDEX</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[orgin_z]" value=<?=$dat[$select]["orgin_z"]?>></td>
</tr>
<tr>
<td>FONT</td>
<td>
<select style="width:195px;" name="app[orgin_font]">
<?foreach($font_name as $a1 => $a2){?>
<option value="<?=$a1?>" <?if($a1 == $dat[$select]["orgin_font"]){?>selected="selected"<?}?>><?=$a1?>:<?=$a2?></option>
<?}?>
</select>
</td>
</tr>
<tr>
<td style="width:100px; text-align:left" >COLOR</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[orgin_color]" value=<?=$dat[$select]["orgin_color"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >size</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[orgin_size]" value=<?=$dat[$select]["orgin_size"]?>></td>
</tr>


<tr>
<td style="width:100px; text-align:left" >POSITION</td>
<td style="width:195px; text-align:left" >
<select style="width:195px;" name="app[orgin_p]">
<option value="1" <?if(1 == $dat[$select]["orgin_p"]){?>selected="selected"<?}?>>1:左上</option>
<option value="2" <?if(2 == $dat[$select]["orgin_p"]){?>selected="selected"<?}?>>2:中上</option>
<option value="3" <?if(3 == $dat[$select]["orgin_p"]){?>selected="selected"<?}?>>3:右上</option>
<option value="4" <?if(4 == $dat[$select]["orgin_p"]){?>selected="selected"<?}?>>4:左下</option>
<option value="5" <?if(5 == $dat[$select]["orgin_p"]){?>selected="selected"<?}?>>5:中下</option>
<option value="6" <?if(6 == $dat[$select]["orgin_p"]){?>selected="selected"<?}?>>6:右下</option>
<option value="7" <?if(7 == $dat[$select]["orgin_p"]){?>selected="selected"<?}?>>7:名前</option>
</select>
</td>
</tr>

<tr>
<td style="width:100px; text-align:left" >X</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[orgin_x]" value=<?=$dat[$select]["orgin_x"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >Y</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[orgin_y]" value=<?=$dat[$select]["orgin_y"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >l_COLOR</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[orgin_line_color]" value=<?=$dat[$select]["orgin_line_color"]?>></td>
</tr>
<tr>
<td style="width:100px; text-align:left" >l_size</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[orgin_line_size]" value=<?=$dat[$select]["orgin_line_size"]?>></td>
</tr>
<tr>
<td style="width:100px; text-align:left" >Direction</td>
<td>
<select style="width:195px;" name="app[orgin_d]">
<option value="0" <?if(0 == $dat[$select]["orgin_d"]){?>selected="selected"<?}?>>0:横書き</option>
<option value="1" <?if(1 == $dat[$select]["orgin_d"]){?>selected="selected"<?}?>>1:縦書き</option>
</select>
</td>
</tr>
<tr>
<td style="width:100px; text-align:left" >Rotate</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[orgin_r]" value=<?=$dat[$select]["orgin_r"]?>></td>
</tr>
</table>



<table>
<tr>
<td colspan="2" style="background:#e0e0e0">CONTACT</td>
</tr>
<tr>
<td style="width:100px; text-align:left" >Z-INDEX</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[contact_z]" value=<?=$dat[$select]["contact_z"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >URL</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[contact]" value=<?=$dat[$select]["contact"]?>></td>
</tr>
<tr>
<td style="width:100px; text-align:left" >OPACITY</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[contact_o]" value=<?=$dat[$select]["contact_o"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >COLOR</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[contact_color]" value=<?=$dat[$select]["contact_color"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >ICON</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[contact_icon_color]" value=<?=$dat[$select]["contact_icon_color"]?>></td>
</tr>
<tr>

<td style="width:100px; text-align:left" >POSITION</td>
<td style="width:195px; text-align:left" >
<select style="width:195px;" name="app[contact_p]">
<option value="1" <?if(1 == $dat[$select]["contact_p"]){?>selected="selected"<?}?>>1:左上</option>
<option value="2" <?if(2 == $dat[$select]["contact_p"]){?>selected="selected"<?}?>>2:中上</option>
<option value="3" <?if(3 == $dat[$select]["contact_p"]){?>selected="selected"<?}?>>3:右上</option>
<option value="4" <?if(4 == $dat[$select]["contact_p"]){?>selected="selected"<?}?>>4:左下</option>
<option value="5" <?if(5 == $dat[$select]["contact_p"]){?>selected="selected"<?}?>>5:中下</option>
<option value="6" <?if(6 == $dat[$select]["contact_p"]){?>selected="selected"<?}?>>6:右下</option>
</select>
</td>
</tr>

<tr>
<td style="width:100px; text-align:left" >X</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[contact_x]" value=<?=$dat[$select]["contact_x"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >Y</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[contact_y]" value=<?=$dat[$select]["contact_y"]?>></td>
</tr>

<!--tr>
<td style="width:100px; text-align:left" >width</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[contact_width]" value=<?=$dat[$select]["contact_width"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >height</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[contact_height]" value=<?=$dat[$select]["contact_height"]?>></td>
</tr-->
<tr>
<td style="width:100px; text-align:left" >L_COLOR</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[contact_line_color]" value=<?=$dat[$select]["contact_line_color"]?>></td>
</tr>
<tr>
<td style="width:100px; text-align:left" >L_SIZE</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[contact_line_size]" value=<?=$dat[$select]["contact_line_size"]?>></td>
</tr>
<tr>
<td style="width:100px; text-align:left" >S_COLOR</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[contact_shadow_color]" value=<?=$dat[$select]["contact_shadow_color"]?>></td>
</tr>
<tr>
<td style="width:100px; text-align:left" >S_SIZE</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[contact_shadow_size]" value=<?=$dat[$select]["contact_shadow_size"]?>></td>
</tr>
</table>


<table>
<tr>
<td colspan="2" style="background:#e0e0e0">QR_CODE</td>
</tr>

<tr>
<td style="width:100px; text-align:left" >POSITION</td>
<td style="width:195px; text-align:left" >
<select style="width:195px;" name="app[qr_p]">
<option value="1" <?if(1 == $dat[$select]["qr_p"]){?>selected="selected"<?}?>>1:左上</option>
<option value="2" <?if(2 == $dat[$select]["qr_p"]){?>selected="selected"<?}?>>2:右上</option>
<option value="3" <?if(3 == $dat[$select]["qr_p"]){?>selected="selected"<?}?>>3:左下</option>
<option value="4" <?if(4 == $dat[$select]["qr_p"]){?>selected="selected"<?}?>>4:右下</option>
</select>
</td>
</tr>

<tr>
<td style="width:100px; text-align:left" >X</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[qr_x]" value=<?=$dat[$select]["qr_x"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >Y</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[qr_y]" value=<?=$dat[$select]["qr_y"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >BASE_COLOR</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[qr_base]" value=<?=$dat[$select]["qr_base"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >TOP_COLOR</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[qr_top]" value=<?=$dat[$select]["qr_top"]?>></td>
</tr>
</table>

</div>
<div style="float:left; width:330px; text-align:center;margin:3px;">

<table>
<tr>
<td colspan="2" style="background:#e0e0e0">FRAME_0</td>
</tr>

<tr>
<td style="width:100px; text-align:left" >Z-INDEX</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[frame0_z]" value=<?=$dat[$select]["frame0_z"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >URL</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[frame0]" value=<?=$dat[$select]["frame0"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >OPACITY</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[frame0_o]" value=<?=$dat[$select]["frame0_o"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >width</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[frame0_w]" value=<?=$dat[$select]["frame0_w"]?>></td>
</tr>

</table>

<table>
<tr>
<td colspan="2" style="background:#e0e0e0">FRAME_1</td>
</tr>

<tr>
<td style="width:100px; text-align:left" >Z-INDEX</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[frame1_z]" value=<?=$dat[$select]["frame1_z"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >URL</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[frame1]" value=<?=$dat[$select]["frame1"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >OPACITY</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[frame1_o]" value=<?=$dat[$select]["frame1_o"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >width</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[frame1_w]" value=<?=$dat[$select]["frame1_w"]?>></td>
</tr>

</table>
<Br>
<table>
<tr>
<td colspan="2" style="background:#e0e0e0">WALL0</td>
</tr>
<tr>
<td style="width:100px; text-align:left" >Z-INDEX</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[wall0_z]" value=<?=$dat[$select]["wall0_z"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >URL</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[wall0]" value=<?=$dat[$select]["wall0"]?>></td>
</tr>
<tr>
<td style="width:100px; text-align:left" >OPACITY</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[wall0_o]" value=<?=$dat[$select]["wall0_o"]?>></td>
</tr>
<tr>
<td style="width:100px; text-align:left" >X</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[wall0_x]" value=<?=$dat[$select]["wall0_x"]?>></td>
</tr>
<tr>
<td style="width:100px; text-align:left" >Y</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[wall0_y]" value=<?=$dat[$select]["wall0_y"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >width</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[wall0_w]" value=<?=$dat[$select]["wall0_w"]?>></td>
</tr>
<tr>
<td style="width:100px; text-align:left" >height</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[wall0_h]" value=<?=$dat[$select]["wall0_h"]?>></td>
</tr>
<tr>
<td style="width:100px; text-align:left" >LINK</td>
<td style="width:195px; text-align:left" >
<select style="width:195px;" name="app[wall0_l]">
<option value="0">0:----</option>
<option value="1" <?if(1 == $dat[$select]["wall0_l"]){?>selected="selected"<?}?>>1:name</option>
<option value="2" <?if(2 == $dat[$select]["wall0_l"]){?>selected="selected"<?}?>>2:contact</option>
<option value="3" <?if(3 == $dat[$select]["wall0_l"]){?>selected="selected"<?}?>>3:orgin</option>
</select>
</td>
</tr>
</table>

<table>
<tr>
<td colspan="2" style="background:#e0e0e0">wall1</td>
</tr>

<tr>
<td style="width:100px; text-align:left" >Z-INDEX</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[wall1_z]" value=<?=$dat[$select]["wall1_z"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >URL</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[wall1]" value=<?=$dat[$select]["wall1"]?>></td>
</tr>
<tr>
<td style="width:100px; text-align:left" >OPACITY</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[wall1_o]" value=<?=$dat[$select]["wall1_o"]?>></td>
</tr>
<tr>
<td style="width:100px; text-align:left" >X</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[wall1_x]" value=<?=$dat[$select]["wall1_x"]?>></td>
</tr>
<tr>
<td style="width:100px; text-align:left" >Y</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[wall1_y]" value=<?=$dat[$select]["wall1_y"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >width</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[wall1_w]" value=<?=$dat[$select]["wall1_w"]?>></td>
</tr>
<tr>
<td style="width:100px; text-align:left" >height</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[wall1_h]" value=<?=$dat[$select]["wall1_h"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >LINK</td>
<td style="width:195px; text-align:left" >
<select style="width:195px;" name="app[wall1_l]">
<option value="0">0:----</option>
<option value="1" <?if(1 == $dat[$select]["wall1_l"]){?>selected="selected"<?}?>>1:name</option>
<option value="2" <?if(2 == $dat[$select]["wall1_l"]){?>selected="selected"<?}?>>2:contact</option>
<option value="3" <?if(3 == $dat[$select]["wall1_l"]){?>selected="selected"<?}?>>3:orgin</option>
</select>
</td>
</tr>

</table>
<table>
<tr>
<td colspan="2" style="background:#e0e0e0">wall2</td>
</tr>

<tr>
<td style="width:100px; text-align:left" >Z-INDEX</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[wall2_z]" value=<?=$dat[$select]["wall2_z"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >URL</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[wall2]" value=<?=$dat[$select]["wall2"]?>></td>
</tr>
<tr>
<td style="width:100px; text-align:left" >OPACITY</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[wall2_o]" value=<?=$dat[$select]["wall2_o"]?>></td>
</tr>
<tr>
<td style="width:100px; text-align:left" >X</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[wall2_x]" value=<?=$dat[$select]["wall2_x"]?>></td>
</tr>
<tr>
<td style="width:100px; text-align:left" >Y</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[wall2_y]" value=<?=$dat[$select]["wall2_y"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >width</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[wall2_w]" value=<?=$dat[$select]["wall2_w"]?>></td>
</tr>
<tr>
<td style="width:100px; text-align:left" >height</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[wall2_h]" value=<?=$dat[$select]["wall2_h"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >LINK</td>
<td style="width:195px; text-align:left" >
<select style="width:195px;" name="app[wall2_l]">
<option value="0">0:----</option>
<option value="1" <?if(1 == $dat[$select]["wall2_l"]){?>selected="selected"<?}?>>1:name</option>
<option value="2" <?if(2 == $dat[$select]["wall2_l"]){?>selected="selected"<?}?>>2:contact</option>
<option value="3" <?if(3 == $dat[$select]["wall2_l"]){?>selected="selected"<?}?>>3:orgin</option>
</select>
</td>
</tr>

</table>

<table>
<tr>
<td colspan="2" style="background:#e0e0e0">wall3</td>
</tr>

<tr>
<td style="width:100px; text-align:left" >Z-INDEX</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[wall3_z]" value=<?=$dat[$select]["wall3_z"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >URL</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[wall3]" value=<?=$dat[$select]["wall3"]?>></td>
</tr>
<tr>
<td style="width:100px; text-align:left" >OPACITY</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[wall3_o]" value=<?=$dat[$select]["wall3_o"]?>></td>
</tr>
<tr>
<td style="width:100px; text-align:left" >X</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[wall3_x]" value=<?=$dat[$select]["wall3_x"]?>></td>
</tr>
<tr>
<td style="width:100px; text-align:left" >Y</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[wall3_y]" value=<?=$dat[$select]["wall3_y"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >width</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[wall3_w]" value=<?=$dat[$select]["wall3_w"]?>></td>
</tr>
<tr>
<td style="width:100px; text-align:left" >height</td>
<td style="width:200px; text-align:left" ><input type="text" style="width:195px;" name="app[wall3_h]" value=<?=$dat[$select]["wall3_h"]?>></td>
</tr>

<tr>
<td style="width:100px; text-align:left" >LINK</td>
<td style="width:195px; text-align:left" >
<select style="width:195px;" name="app[wall3_l]">
<option value="0">0:----</option>
<option value="1" <?if(1 == $dat[$select]["wall3_l"]){?>selected="selected"<?}?>>1:name</option>
<option value="2" <?if(2 == $dat[$select]["wall3_l"]){?>selected="selected"<?}?>>2:contact</option>
<option value="3" <?if(3 == $dat[$select]["wall3_l"]){?>selected="selected"<?}?>>3:orgin</option>
</select>
</td>
</tr>
</table>

</div>
<div style="float:left; width:250px; text-align:left;margin:3px;">


</div>
</form>





</body>
</html>
