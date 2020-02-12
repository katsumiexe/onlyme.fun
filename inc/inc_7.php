<?php
//■wall3-------------
if($dat_tmpl['wall3']){
	if(strpos($wall3, "png")){
		$tmp_wall = imagecreatefrompng("./img/wall/{$dat_tmpl['wall3']}");
		$tmp_width	= imagesx($tmp_wall);
		$tmp_height	= imagesy($tmp_wall);
		imagealphablending($tmp_wall, false);
		imagesavealpha($tmp_wall, true);
		ImageCopyResampled($tmp2, $tmp_wall, $wall3_x, $wall3_y, 0, 0, $wall3_w, $wall3_h, $tmp_width, $tmp_height);
		ImageCopyResampled($tmpn, $tmp_wall, $wall3_x, $wall3_y, 0, 0, $wall3_w, $wall3_h, $tmp_width, $tmp_height);
	}else{


	if($dat_tmpl['wall3_l'] == 1){
		$wall3_x=$name_x-$wall3_x;
		$wall3_w=$name_x+$name_w+$wall3_w;

		$wall3_y=$name_y+$name_size_tmp[5]-$wall3_y-$b;
		$wall3_h=$name_y+$name_size_tmp[5]+$name_h+$wall3_h+$b;

	}elseif($dat_tmpl['wall3_l'] == 2){
		$wall3_w=$cont_x2+$wall3_x*$b;
		$wall3_x=$cont_x1-$wall3_x*$b;

		$wall3_h=$cont_y2+$wall3_y*$b;
		$wall3_y=$cont_y1-$wall3_y*$b;

	}elseif($dat_tmpl['wall3_l'] == 3){
		$wall3_w=$orgin_x+$orgin_w+$wall3_x*$b;
		$wall3_x=$orgin_x-$wall3_x*$b;

		$wall3_h=$orgin_y+$orgin_h+$wall3_y*$b;
		$wall3_y=$orgin_y-$wall3_y*$b;

	}else{
		$wall3_w=$wall3_w+$wall3_x;
		$wall3_h=$wall3_h+$wall3_y;
	}

		$tmp_w=str_replace("#","",$wall3);
		$r_w=hexdec(substr($tmp_w,0,2));
		$g_w=hexdec(substr($tmp_w,2,2));
		$b_w=hexdec(substr($tmp_w,4,2));
		$o=floor(127*(1-$wall3_o));

		$tmp_color=imagecolorallocatealpha($tmp2,$r_w,$g_w,$b_w,$o);
		$tmp_colorn=imagecolorallocatealpha($tmpn,$r_w,$g_w,$b_w,$o);
		imagefilledrectangle($tmp2, $wall3_x, $wall3_y, $wall3_w, $wall3_h, $tmp_color);
		imagefilledrectangle($tmpn, $wall3_x, $wall3_y, $wall3_w, $wall3_h, $tmp_colorn);
	}
}
?>	
