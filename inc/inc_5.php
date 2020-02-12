<?php
//■wall1-------------
if($dat_tmpl['wall1']){
	if(strpos($wall1, "png")){
		$tmp_wall = imagecreatefrompng("./img/wall/{$dat_tmpl['wall1']}");
		$tmp_width	= imagesx($tmp_wall);
		$tmp_height	= imagesy($tmp_wall);
		imagealphablending($tmp_wall, false);
		imagesavealpha($tmp_wall, true);
		ImageCopyResampled($tmp2, $tmp_wall, $wall1_x, $wall1_y, 0, 0, $wall1_w, $wall1_h, $tmp_width, $tmp_height);
		ImageCopyResampled($tmpn, $tmp_wall, $wall1_x, $wall1_y, 0, 0, $wall1_w, $wall1_h, $tmp_width, $tmp_height);
	}else{


	if($dat_tmpl['wall1_l'] == 1){
		$wall1_x=$name_x-$wall1_x;
		$wall1_w=$name_x+$name_w+$wall1_w;

		$wall1_y=$name_y+$name_size_tmp[5]-$wall1_y-$b;
		$wall1_h=$name_y+$name_size_tmp[5]+$name_h+$wall1_h+$b;

	}elseif($dat_tmpl['wall1_l'] == 2){
		$wall1_w=$cont_x2+$wall1_x*$b;
		$wall1_x=$cont_x1-$wall1_x*$b;

		$wall1_h=$cont_y2+$wall1_y*$b;
		$wall1_y=$cont_y1-$wall1_y*$b;

	}elseif($dat_tmpl['wall1_l'] == 3){
		$wall1_w=$orgin_x+$orgin_w+$wall1_x*$b;
		$wall1_x=$orgin_x-$wall1_x*$b;

		$wall1_h=$orgin_y+$orgin_h+$wall1_y*$b;
		$wall1_y=$orgin_y-$wall1_y*$b;

	}else{
		$wall1_w=$wall1_w+$wall1_x;
		$wall1_h=$wall1_h+$wall1_y;
	}

		$tmp_w=str_replace("#","",$wall1);
		$r_w=hexdec(substr($tmp_w,0,2));
		$g_w=hexdec(substr($tmp_w,2,2));
		$b_w=hexdec(substr($tmp_w,4,2));
		$o=floor(127*(1-$wall1_o));

		$tmp_color=imagecolorallocatealpha($tmp2,$r_w,$g_w,$b_w,$o);
		$tmp_colorn=imagecolorallocatealpha($tmpn,$r_w,$g_w,$b_w,$o);
		imagefilledrectangle($tmp2, $wall1_x, $wall1_y, $wall1_w, $wall1_h, $tmp_color);
		imagefilledrectangle($tmpn, $wall1_x, $wall1_y, $wall1_w, $wall1_h, $tmp_colorn);
	}
}
?>	
