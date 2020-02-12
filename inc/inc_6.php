<?php
//■wall2-------------
if($dat_tmpl['wall2']){
	if(strpos($wall2, "png")){
		$tmp_wall = imagecreatefrompng("./img/wall/{$dat_tmpl['wall2']}");
		$tmp_width	= imagesx($tmp_wall);
		$tmp_height	= imagesy($tmp_wall);
		imagealphablending($tmp_wall, false);
		imagesavealpha($tmp_wall, true);
		ImageCopyResampled($tmp2, $tmp_wall, $wall2_x, $wall2_y, 0, 0, $wall2_w, $wall2_h, $tmp_width, $tmp_height);
		ImageCopyResampled($tmpn, $tmp_wall, $wall2_x, $wall2_y, 0, 0, $wall2_w, $wall2_h, $tmp_width, $tmp_height);
	}else{


	if($dat_tmpl['wall2_l'] == 1){
		$wall2_x=$name_x-$wall2_x;
		$wall2_w=$name_x+$name_w+$wall2_w;

		$wall2_y=$name_y+$name_size_tmp[5]-$wall2_y-$b;
		$wall2_h=$name_y+$name_size_tmp[5]+$name_h+$wall2_h+$b;

	}elseif($dat_tmpl['wall2_l'] == 2){
		$wall2_w=$cont_x2+$wall2_x*$b;
		$wall2_x=$cont_x1-$wall2_x*$b;

		$wall2_h=$cont_y2+$wall2_y*$b;
		$wall2_y=$cont_y1-$wall2_y*$b;

	}elseif($dat_tmpl['wall2_l'] == 3){
		$wall2_w=$orgin_x+$orgin_w+$wall2_x*$b;
		$wall2_x=$orgin_x-$wall2_x*$b;

		$wall2_h=$orgin_y+$orgin_h+$wall2_y*$b;
		$wall2_y=$orgin_y-$wall2_y*$b;

	}else{
		$wall2_w=$wall2_w+$wall2_x;
		$wall2_h=$wall2_h+$wall2_y;
	}

		$tmp_w=str_replace("#","",$wall2);
		$r_w=hexdec(substr($tmp_w,0,2));
		$g_w=hexdec(substr($tmp_w,2,2));
		$b_w=hexdec(substr($tmp_w,4,2));
		$o=floor(127*(1-$wall2_o));

		$tmp_color=imagecolorallocatealpha($tmp2,$r_w,$g_w,$b_w,$o);
		$tmp_colorn=imagecolorallocatealpha($tmpn,$r_w,$g_w,$b_w,$o);
		imagefilledrectangle($tmp2, $wall2_x, $wall2_y, $wall2_w, $wall2_h, $tmp_color);
		imagefilledrectangle($tmpn, $wall2_x, $wall2_y, $wall2_w, $wall2_h, $tmp_colorn);
	}
}
?>	
