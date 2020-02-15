<?php
//■contact-------------------------------------
if(mb_strlen($insta)>250){
	$insta=substr($insta,0,25)."…";
}
if($cont1>0){	
	if(strpos($dat_tmpl['contact'], "png")){
		$cont_img = imagecreatetruecolor($cont_width,$cont_height);
		$cont_bk = imagecreatefrompng("./img/contact/{$dat_tmpl['contact']}");
		ImageCopyResampled($tmp2, $cont_bk, $cont_x1, $cont_y1, 0, 0, $cont_x2-$cont_x1, $cont_y2-$cont_y1, $cont_x2-$cont_x1, $cont_y2-$cont_y1);
		ImageCopyResampled($tmpn, $cont_bk, $cont_x1, $cont_y1, 0, 0, $cont_x2-$cont_x1, $cont_y2-$cont_y1, $cont_x2-$cont_x1, $cont_y2-$cont_y1);

	}else{

		if($dat_tmpl['contact_line_color'] && $dat_tmpl['contact_line_size']>0){
			$tmp_l=$dat_tmpl['contact_line_size']*$b;
			$r=hexdec(substr($dat_tmpl['contact_line_color'],1,2));
			$g=hexdec(substr($dat_tmpl['contact_line_color'],3,2));
			$l=hexdec(substr($dat_tmpl['contact_line_color'],5,2));
			$o=floor(127*(1-$dat_tmpl['contact_o']));

			$tmp_color=imagecolorallocatealpha($tmp2,$r,$g,$l,$o);
			$tmp_colorn=imagecolorallocatealpha($tmpn,$r,$g,$l,$o);

			//■
			$x1=$cont_x1-$tmp_l;
			$x2=$cont_x2+$tmp_l;
			$y1=$cont_y1-$tmp_l;
			$y2=$cont_y1-1;
			imagefilledrectangle($tmp2, $x1, $y1, $x2, $y2,$tmp_color);
			imagefilledrectangle($tmpn, $x1, $y1, $x2, $y2,$tmp_colorn);

			$x1=$cont_x1-$tmp_l;
			$x2=$cont_x2+$tmp_l;
			$y1=$cont_y2+1;
			$y2=$cont_y2+$tmp_l;
			imagefilledrectangle($tmp2, $x1, $y1, $x2, $y2,$tmp_color);
			imagefilledrectangle($tmpn, $x1, $y1, $x2, $y2,$tmp_colorn);

			$x1=$cont_x1-$tmp_l;
			$x2=$cont_x1-1;
			$y1=$cont_y1;
			$y2=$cont_y2;
			imagefilledrectangle($tmp2, $x1, $y1, $x2, $y2,$tmp_color);
			imagefilledrectangle($tmpn, $x1, $y1, $x2, $y2,$tmp_colorn);

			$x1=$cont_x2+1;
			$x2=$cont_x2+$tmp_l;
			$y1=$cont_y1;
			$y2=$cont_y2;
			imagefilledrectangle($tmp2, $x1, $y1, $x2, $y2,$tmp_color);
			imagefilledrectangle($tmpn, $x1, $y1, $x2, $y2,$tmp_colorn);
		}

		if($dat_tmpl['contact_shadow_color'] && $dat_tmpl['contact_shadow_size']>0){
			$tmp_s=$dat_tmpl['contact_shadow_size'];
			$r=hexdec(substr($dat_tmpl['contact_shadow_color'],1,2));
			$g=hexdec(substr($dat_tmpl['contact_shadow_color'],3,2));
			$l=hexdec(substr($dat_tmpl['contact_shadow_color'],5,2));
			$tmp_color=imagecolorallocatealpha($tmp2,$r,$g,$l,1);
			$tmp_colorn=imagecolorallocatealpha($tmpn,$r,$g,$l,1);

			imagefilledrectangle($tmp2, $cont_x2+$tmp_l+1,$cont_y1+$tmp_s, $cont_x2+$tmp_l+$tmp_s, $cont_y2+$tmp_s+$tmp_l,$tmp_color);
			imagefilledrectangle($tmp2, $cont_x1+$tmp_s,$cont_y2+$tmp_l+1, $cont_x2+$tmp_l, $cont_y2+$tmp_l+$tmp_s,$tmp_color);

			imagefilledrectangle($tmpn, $cont_x2+$tmp_l+1,$cont_y1+$tmp_s, $cont_x2+$tmp_l+$tmp_s, $cont_y2+$tmp_s+$tmp_l,$tmp_colorn);
			imagefilledrectangle($tmpn, $cont_x1+$tmp_s,$cont_y2+$tmp_l+1, $cont_x2+$tmp_l, $cont_y2+$tmp_l+$tmp_s,$tmp_colorn);
		}

		$tmp=str_replace("#","",$dat_tmpl['contact']);
		$r=hexdec(substr($tmp,0,2));
		$g=hexdec(substr($tmp,2,2));
		$l=hexdec(substr($tmp,4,2));
		$o=floor(127*(1-$dat_tmpl['contact_o']));
		$tmp_color=imagecolorallocatealpha($tmp2,$r,$g,$l,$o);

		imagefilledrectangle($tmp2,$cont_x1, $cont_y1, $cont_x2, $cont_y2,$tmp_color);

		$tmp_colorn=imagecolorallocatealpha($tmpn,$r,$g,$l,$o);
		imagefilledrectangle($tmpn,$cont_x1, $cont_y1, $cont_x2, $cont_y2,$tmp_colorn);
	}

	$tmp=str_replace("#","",$dat_tmpl['contact_color']);
	$r=hexdec(substr($tmp,0,2));
	$g=hexdec(substr($tmp,2,2));
	$l=hexdec(substr($tmp,4,2));
	$tmp_color		=imagecolorallocatealpha($tmp2,$r,$g,$l,0);
	$cosp_color		=imagecolorallocatealpha($tmp2,250,0,0,0);
	$cosp_color2	=imagecolorallocatealpha($tmp2,255,255,255,0);

	$tmp_colorn		=imagecolorallocatealpha($tmpn,$r,$g,$l,0);
	$cosp_colorn	=imagecolorallocatealpha($tmpn,250,0,0,0);
	$cosp_color2n	=imagecolorallocatealpha($tmpn,255,255,255,0);

	$cy=$cont_y1+$f_margin;
	if($twitter){
		imagettftext($tmp2, $f_size, 0, $cont_x1+$f_margin+$b*3, $cy-2	, $tmp_color, $cont_font, $twitter);
		imagettftext($tmp2, $f_size, 0, $cont_x1+$i_margin, $cy	, $tmp_color, $icon_font, '');

		imagettftext($tmpn, $f_size, 0, $cont_x1+$f_margin+$b*3, $cy-2	, $tmp_colorn, $cont_font, "xxxxxxx");
		imagettftext($tmpn, $f_size, 0, $cont_x1+$i_margin, $cy	, $tmp_colorn, $icon_font, '');
		$cy+=$f_margin;
	}

	if($insta){
		imagettftext($tmp2, $f_size, 0, $cont_x1+$f_margin+$b*3, $cy-2	, $tmp_color, $cont_font, $insta);
		imagettftext($tmp2, $f_size, 0, $cont_x1+$i_margin, $cy	, $tmp_color, $icon_font, '');

		imagettftext($tmpn, $f_size, 0, $cont_x1+$f_margin+$b*3, $cy-2	, $tmp_colorn, $cont_font, "xxxxxxx");
		imagettftext($tmpn, $f_size, 0, $cont_x1+$i_margin, $cy	, $tmp_colorn, $icon_font, '');
		$cy+=$f_margin;
	}

	if($cosp){
		imagettftext($tmp2, $f_size, 0, $cont_x1+$f_margin+$b*3, $cy-2	, $tmp_color, $cont_font,$cosp);
		imagettftext($tmp2, $f_size, 0, $cont_x1+$i_margin, $cy	, $tmp_color, $icon_font,'');

		imagettftext($tmpn, $f_size, 0, $cont_x1+$f_margin+$b*3, $cy-2	, $tmp_colorn, $cont_font, "xxxxxx");
		imagettftext($tmpn, $f_size, 0, $cont_x1+$i_margin, $cy	, $tmp_colorn, $icon_font, '');
	}

	//	$tmp=str_replace("#","",$dat_tmpl['icon']);
//	$r=hexdec(substr($tmp,0,2));
//	$g=hexdec(substr($tmp,2,2));
//	$b=hexdec(substr($tmp,4,2));
//	$tmp_color=imagecolorallocatealpha($tmp2,$r,$g,$b,0);
}
?>
