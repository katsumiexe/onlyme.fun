<?php
//■wall0-------------
if($dat_tmpl['wall0']){
	if(strpos($wall0, "png")){
		$tmp_wall = imagecreatefrompng("./img/wall/{$dat_tmpl['wall0']}");
		$tmp_width	= imagesx($tmp_wall);
		$tmp_height	= imagesy($tmp_wall);
		imagealphablending($tmp_wall, false);
		imagesavealpha($tmp_wall, true);
		ImageCopyResampled($tmp2, $tmp_wall, $wall0_x, $wall0_y, 0, 0, $wall0_w, $wall0_h, $tmp_width, $tmp_height);
		ImageCopyResampled($tmpn, $tmp_wall, $wall0_x, $wall0_y, 0, 0, $wall0_w, $wall0_h, $tmp_width, $tmp_height);
	}else{


	if($dat_tmpl['wall0_l'] == 1){
		$wall0_x=$name_x-$wall0_x;
		$wall0_w=$name_x+$name_w+$wall0_w;

		$wall0_y=$name_y+$name_size_tmp[5]-$wall0_y-$b;
		$wall0_h=$name_y+$name_size_tmp[5]+$name_h+$wall0_h+$b;

	}elseif($dat_tmpl['wall0_l'] == 2){
		$wall0_w=$cont_x2+$wall0_x*$b;
		$wall0_x=$cont_x1-$wall0_x*$b;

		$wall0_h=$cont_y2+$wall0_y*$b;
		$wall0_y=$cont_y1-$wall0_y*$b;

	}elseif($dat_tmpl['wall0_l'] == 3){
		$wall0_w=$orgin_x+$orgin_w+$wall0_x*$b;
		$wall0_x=$orgin_x-$wall0_x*$b;

		$wall0_h=$orgin_y+$orgin_h+$wall0_y*$b;
		$wall0_y=$orgin_y-$wall0_y*$b;

	}else{
		$wall0_w=$wall0_w+$wall0_x;
		$wall0_h=$wall0_h+$wall0_y;
	}

		$tmp_w=str_replace("#","",$wall0);
		$r_w=hexdec(substr($tmp_w,0,2));
		$g_w=hexdec(substr($tmp_w,2,2));
		$b_w=hexdec(substr($tmp_w,4,2));
		$o=floor(127*(1-$wall0_o));

		$tmp_color=imagecolorallocatealpha($tmp2,$r_w,$g_w,$b_w,$o);
		$tmp_colorn=imagecolorallocatealpha($tmpn,$r_w,$g_w,$b_w,$o);
		imagefilledrectangle($tmp2, $wall0_x, $wall0_y, $wall0_w, $wall0_h, $tmp_color);
		imagefilledrectangle($tmpn, $wall0_x, $wall0_y, $wall0_w, $wall0_h, $tmp_colorn);
	}
}
?>	
